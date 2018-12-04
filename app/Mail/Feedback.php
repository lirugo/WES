<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Feedback extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $title;
    public $body;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $title, $body)
    {
        $this->user = $user;
        $this->title = $title;
        $this->body = $body;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.feedback');
    }
}
