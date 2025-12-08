<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Notificacion extends Mailable
{
    use Queueable, SerializesModels;

    public $data; // English comment: Data passed to the email view
    public $subject;

    public function __construct($data, $subject)
    {
        $this->data = $data;
        $this->subject = $subject;
    }

    public function build()
    {
        // English comment: Build the email message
        return $this->subject($this->subject)
                    ->view('emails.mi_mailable')
                    ->with([
                        'data' => $this->data,
                    ]);
    }
}
