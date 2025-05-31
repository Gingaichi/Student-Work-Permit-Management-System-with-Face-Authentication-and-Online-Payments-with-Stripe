<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StatusUpdated extends Mailable
{
    use Queueable, SerializesModels;

    public $status;
    public $applicantName;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($status, $applicantName)
    {
        $this->status = $status;
        $this->applicantName = $applicantName;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.status_updated') // View for email content
                    ->with([
                        'status' => $this->status,
                        'applicantName' => $this->applicantName,
                    ]);
    }
}
