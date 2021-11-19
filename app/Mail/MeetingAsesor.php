<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MeetingAsesor extends Mailable
{
    use Queueable, SerializesModels;
    protected $meeting;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($meeting)
    {
        $this->meeting = $meeting;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('crm@casabaca.com', 'SugarCRM')
            ->view('emails.meeting_asesor')
            ->with(['meeting' => $this->meeting]);
        //return $this->view('view.name');
    }
}
