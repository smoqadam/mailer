<?php

namespace App\Console\Commands;

use App\Mail\Mailable;
use App\Mail\Mailer;
use App\Mail\Providers\Sendgrid;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\HttpClient\HttpClient;

class MailSend extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:send {name} {email} {subject} {body} {--isHtml} {--queue}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send an email by command line';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->ask('name');
        $email = $this->ask('email');
        $subject = $this->ask('subject');
        $isHtml = $this->confirm('is html?');
        $body = $this->ask('body');
        $addToQueue = $this->confirm('do you want to add it to queue?', true);

        $mailable = new Mailable();
        $mailable->setEmail($email);
        $mailable->setName($name);
        $mailable->setBody($body);
        $mailable->setSubject($subject);
        $mailable->setIsHtml($isHtml);
        $mailer = (new Mailer());

        if ($addToQueue) {
            $this->info('Email added to the queue');
            $mailer->queue($mailable);
        }else {
            $mailer->setProvider(new Sendgrid(HttpClient::create()));
            $mailer->send($mailable);
            $this->info('Email sent successfully');
        }

        return 0;
    }
}
