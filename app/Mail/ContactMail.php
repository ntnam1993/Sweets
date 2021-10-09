<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable implements ShouldQueue
{   
    use Queueable, SerializesModels;

    public $params = [];

    /**
     * Creates a new message instance.
     *
     * @return void
     */
    public function __construct($params = [])
    {
        $this->params = $params;
    }

    /**
     * Builds the message.
     *
     * @return $this
     */
    public function build()
    {   
        return $this->view('emails.contact.index')
            ->from(env('MAIL_FROM'), 'EPARKスイーツガイド運営事務局')
            ->subject('お問い合わせを受付ました。')
            ->with(['data' => $this->params]);
    }
}
