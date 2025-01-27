<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PasswordResetMail extends Mailable
{
    use Queueable, SerializesModels;


    public string $password;
    public string $name;
    /**
     * Create a new message instance.
     */
    public function __construct( string $password, string $name )
    {
        $this->password = $password;
        $this->name = $name;

        //
    }

    public function build()

    {

        //dd($this->name, $this->password);
        return $this->subject('Password Reset')
            ->view('emails.password_reset')
            ->with([
                'password' => $this->password,
                'name' => $this->name

            ]);
    }
    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
