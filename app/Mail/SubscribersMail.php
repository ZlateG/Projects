<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SubscribersMail extends Mailable
{
    use Queueable, SerializesModels;

    public $content;
    public $subscriberId;

    /**
     * Create a new message instance.
     *
     * @param  string  $content
     * @return void
     */
    public function __construct($content , $subscriberId)
    {
        $this->content = $content;
        $this->subscriberId = $subscriberId;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.subscribers-mail')
                    ->subject('Subject of the email');
    }
}