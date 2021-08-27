<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        //
         $this->name = $data['name'];
         $this->email = $data['email'];
         $this->md5 = $data['md5'];
         $this->pass = $data['pass'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to( $this->email )  
        ->subject('登録完了しました。')
        ->view('mail.regist')
        ->with(['name' => $this->name,
                'email' => $this->email,
                'md5' => $this->md5,
                'pass' => $this->pass,
                ]);
        // 送信先アドレス -> 件名 -> 本文 -> 本文に送る値
    }
}
