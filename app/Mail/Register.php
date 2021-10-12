<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Register extends Mailable {

    use Queueable,
        SerializesModels;

    public $user, $token;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user,$token) {
        $this->user = $user;
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        $address = env('MAIL_USERNAME');
        $name = 'Konfirmasi Email';
        $subject =  'Konfirmasi Pendaftaran Pengguna';
        return $this->view('emails.register')->from($address, $name)->subject($subject);
    }

}
