<?php

namespace App\Jobs;

use App\Mail\Contracts\Mailable;
use App\Mail\ProviderCollection;
use App\Mail\Providers\Sendgrid;
use App\Mail\Providers\Sendinblue;
use App\Mail\SendQueuedMailable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Symfony\Component\HttpClient\HttpClient;

class MailSend implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    private Mailable $mailable;

    private ProviderCollection $providers;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Mailable $mailable)
    {
        $this->mailable = $mailable;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(SendQueuedMailable $queuedMailable)
    {
        $queuedMailable
            ->addProvider(new Sendgrid(HttpClient::create()))
            ->addProvider(new Sendinblue(HttpClient::create()))
            ->send($this->mailable);
    }
}
