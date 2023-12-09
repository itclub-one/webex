<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StatusPendaftarMail extends Mailable
{
    use Queueable, SerializesModels;

    public $mailData;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mailData)
    {
        $this->mailData = $mailData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('administrator.pendaftaran.mail.status')
                    ->subject($this->mailData['title'])
                    ->with([
                        'content' => $this->mailData['content'],
                        'nama' => $this->mailData['nama'],
                        'nis' => $this->mailData['nis'],
                        'kelas' => $this->mailData['kelas'],
                        'jurusan' => $this->mailData['jurusan'],
                        'email' => $this->mailData['email'],
                        'telepon' => $this->mailData['telepon'],
                        'alasan_masuk' => $this->mailData['alasan_masuk'],
                        'status' => $this->mailData['status'],
                    ]);
    }
}
