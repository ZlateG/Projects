<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactUsAnswerMail extends Mailable
{
    use Queueable, SerializesModels;

    public $answer;

    /**
     * Create a new message instance.
     *
     * @param string $answer
     */
    public function __construct($answer)
    {
        $this->answer = $answer;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.contact-us-answer')
                    ->subject('Your Contact Us Answer');
    }
}
