<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AnswerMail extends Mailable
{
    use Queueable, SerializesModels;
    public $questions;
    public $useranswer;
    public $options;
    public $quizname;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct( $questions, $useranswer,$quizname)
    {
        $this->questions = $questions;
        $this->useranswer = $useranswer;
        $this->quizname=$quizname;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Answer Mail',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'mails.resultmail',
            with: [
                'useranswer' => $this->useranswer,
                'quizname'=>$this->quizname,

            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
