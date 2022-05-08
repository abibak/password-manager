<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CreatedUser extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    private $dataRegistered;

    /**
     * Create a new message instance.
     *
     * @param $dataRegistered
     */
    public function __construct($dataRegistered)
    {
        $this->dataRegistered = $dataRegistered;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.user.create')
            ->subject('Регистрация в системе')
            ->with('data', $this->dataRegistered);
    }
}
