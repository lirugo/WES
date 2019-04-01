<?php

namespace App\Notifications\Team;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NotifNewActivity extends Notification
{
    use Queueable;


    private $activity;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($activity)
    {
        $this->activity = $activity;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', Auth()->user()->settingNotifications->email_new_activity ? 'mail' : ''];
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
            ->line('Created new activity')
            ->action('Open page', url('/team/'.$this->activity->team->name.'/activity/'.$this->activity->discipline->name))
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
            'title' => 'Created new activity',
            'body' => 'In your team was be created new activity. '.$this->activity->name,
            'url' => url('/team/'.$this->activity->team->name.'/activity/'.$this->activity->discipline->name),
        ];
    }
}
