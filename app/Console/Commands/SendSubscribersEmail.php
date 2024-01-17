<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Mail\SubscribersMail;
use Illuminate\Support\Facades\Mail;
use App\Models\Subscriber;

class SendSubscribersEmail extends Command
{
    protected $signature = 'email:send-subscribers';
    protected $description = 'Send an email to all subscribers';

    public function handle()
    {
        $subscribers = Subscriber::all();

        foreach ($subscribers as $subscriber) {
            Mail::to($subscriber->email)->send(new SubscribersMail());
        }

        $this->info('Emails sent to all subscribers successfully!');
    }
}