<?php

namespace App\Providers;

use App\Mail\Contracts\MailerInterface;
use App\Mail\Mailer;
use Illuminate\Log\Logger;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(MailerInterface::class, function() {
            return new Mailer($this->app->make(Logger::class));
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
