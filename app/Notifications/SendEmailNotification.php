<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendEmailNotification extends Notification
{
    use Queueable;
     private $details;
    /**
     * Create a new notification instance.
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $subject = isset($this->details['subject']) ? $this->details['subject'] : 'Notification: New ETEEAP Application Received - Action Required';

        return (new MailMessage)
        
                    ->subject($subject)
                    //->attach(public_path('requirement/Qualification-and-Requirements.pdf'), [
                       // 'as' => 'Qualification-and-Requirements.pdf',
                       // 'mime' => 'application/pdf',
                    //])
                    ->greeting($this->details['greetings'])
                    ->line($this->details['body'])
                    ->line($this->details['body1'])
                    ->line($this->details['body2'])
                    ->line($this->details['body3'])
                    ->line($this->details['body4'])
                    ->line($this->details['body5'])
                    ->line($this->details['body6'])
                    ->line($this->details['body7'])
                    ->line($this->details['body8'])
                    ->action($this->details['actiontext'],$this->details['actionurl'])
                    ->line($this->details['lastline'])
                    ->line($this->details['lastline2'])
                    ->line($this->details['lastline3'])
                    ->line($this->details['lastline4'])
                    ->line($this->details['lastline5']);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
