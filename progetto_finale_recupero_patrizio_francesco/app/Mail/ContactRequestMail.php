<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    public array $data; // Proprietà pubblica per contenere i dati del form

    /**
     * Create a new message instance.
     *
     * @param array $data I dati validati del form di contatto
     */
    public function __construct(array $data)
    {
        $this->data = $data; 
    }


    public function envelope(): Envelope
    {
        return new Envelope(
            from: $this->data['email'], // Email di chi ha compilato il form
            subject: 'Nuova Richiesta di Contatto da: ' . $this->data['name'], // Oggetto dell'email
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.contact.request', // Il template 
            // 
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