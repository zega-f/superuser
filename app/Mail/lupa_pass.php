<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class lupa_pass extends Mailable
{
    use Queueable, SerializesModels;
    public $recipient;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     //
    // }

    public function __construct($recipient)
    {
        $this->recipient = $recipient;
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    // public function build()
    // {
    //     return $this->view('lupa_password');
    // }


    public function build()
    {
        $pesan = $this->recipient['otp'];
        return $this->from('cobajyby@gmail.com', 'Astartekno')
        ->subject('Reset Password')
        ->view('reset_password')
        ->with([
            'konten'=>$pesan,
        ]);
    }
}
