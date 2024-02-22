<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InvioPassword extends Mailable
{
    use Queueable, SerializesModels;


    private string $anagrafica;


    private string $password;

    private string $app_portal;

    /**
     * @param string $anagrafica
     * @param string $password
     */
    public function __construct(string $anagrafica, string $password)
    {
        $this->anagrafica = $anagrafica;
        $this->password   = $password;
        $this->app_portal =env('APP_URL') ."/reset/password";
    }
    /**
     * Create a new message instance.
     */


    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Invio Password',

        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email.invio_password',with: ["anagrafica"=> $this->anagrafica,'password'=>$this->password,'app_portal' => $this->app_portal],

        );
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
