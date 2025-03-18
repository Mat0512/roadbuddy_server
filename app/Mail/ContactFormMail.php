<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactFormMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    /**
     * Create a new message instance.
     *
     * @param array $data
     */
    public function __construct($data)
    {
        $this->data = $data;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('mathewmendoza777@gmail.com', $this->data['name']) // Add this line
                    ->replyTo('mathewmendoza777@gmail.com')
                    ->subject($this->data['subject'])
                    ->view('emails.contact-form')
                    ->with(['data' => $this->data])
                     ->withSwiftMessage(function ($message) {
                    $headers = $message->getHeaders();
                    $headers->remove('Reply-To'); // Removes the Reply-To header
                });;
    }
}