<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Email;
use Illuminate\Mail\Mailables\Attachment;



class MailShipped extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $data;
    // public $path;
    public $attachmentPaths;

    public $originalFileName;

    // public function __construct($data)
    // {
    //     $this->data = $data;
    // }

    // public function __construct($data, $path = null, $originalFileName = null)
    public function __construct($data, $attachmentPaths = null, $originalFileName = null)
    {
        $this->data = $data;
        // $this->path = $path;
        $this->attachmentPaths = $attachmentPaths;
        $this->originalFileName = $originalFileName;
    }



    public function build()
    {

        $count = Email::where('read', false)->count();
        $deleteCount = Email::onlyTrashed()->where('read', false)->count();
        return $this->subject('Тема листа')->view('erp.parts.emails.new_email', compact('count', 'deleteCount'));
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->data['subject'],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(

            view: 'erp.parts.emails.mail_template',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        // if ($this->path && $this->originalFileName) {
        //     return [
        //         Attachment::fromPath($this->path)->as($this->originalFileName),
        //     ];
        // }
        // return [];

        $attachments = [];

        if ($this->attachmentPaths) {
            foreach ($this->attachmentPaths as $path) {
                $attachments[] = Attachment::fromPath($path);
            }
        }

        return $attachments;
    }
}
