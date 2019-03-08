<?php

namespace App\Notifications\Team;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotifNewActivityMessage extends Notification
{
    use Queueable;

    private $activity;
    private $student;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($activity, $student)
    {
        $this->activity = $activity;
        $this->student = $student;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'title' => 'You have a new message in activity',
            'body' => $this->activity->name,
            'url' => url('/team/'.$this->activity->team->name.'/activity/'.$this->activity->discipline->name.'/pass/'.$this->activity->id.'/'.$this->student->id),
        ];
    }
}
