<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminSendEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $content;
    public $subjectFromAdmin;
    public $user;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subjectFromAdmin, $content, $user)
    {
        $this->subjectFromAdmin = $subjectFromAdmin;
        $this->content = $content;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subjectFromAdmin)->view('emails.system.admin_notification');
    }
}
