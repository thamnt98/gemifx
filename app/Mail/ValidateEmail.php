<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ValidateEmail extends Mailable
{

    /**
     * @var string
     */
    protected $otp;




    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($otp)
    {
        $this->otp = $otp;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.otp')
            ->subject('Mã otp')
            ->with([
                'otp' => $this->otp
            ]);
    }
}
