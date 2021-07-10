<?php

namespace App\Http\Controllers;

use App\Mail\Mailable;
use App\Mail\Mailer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MailController extends Controller
{
    private Mailer $mailer;

    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function send(Request $request)
    {
        $data = $request->json()->all();
        $request->merge($data);
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'name' => 'required',
            'body' => 'required',
            'isHtml' => 'required',
            'subject' => 'required',
        ]);

        if ($validator->fails()) {
            return [
                'error' => 'validation failed',
                'messages' => $validator->errors()->all(),
            ];
        }

        $mailable = new Mailable();
        $mailable->setEmail($data['email']);
        $mailable->setName($data['name']);
        $mailable->setBody($data['body']);
        $mailable->setSubject($data['subject']);
        $mailable->setIsHtml($data['isHtml']);

        $this->mailer->queue($mailable);

        return ['message' => 'email added to queue'];
    }
}
