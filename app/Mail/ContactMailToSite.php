<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMailToSite extends Mailable implements ShouldQueue
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
        $params = $this->params;
        return $this->view('emails.contact.index_to_site')
            ->from($params['email'])
            ->subject('【EPARKスイーツガイド】問合せ')
            ->with(['data' => $this->params]);
    }
}
