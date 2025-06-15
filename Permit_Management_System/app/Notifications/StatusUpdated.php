<?php
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class StatusUpdated extends Notification
{
    public $status;

    public function __construct($status)
    {
        $this->status = $status;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return new DatabaseMessage([
            'status' => $this->status,
            'message' => "Your application status has been updated to: $this->status",
        ]);
    }
}

