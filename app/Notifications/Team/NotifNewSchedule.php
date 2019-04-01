<?php

namespace App\Notifications\Team;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NotifNewSchedule extends Notification
{
    use Queueable;

    private $schedule;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($schedule)
    {
        $this->schedule = $schedule;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', Auth()->user()->settingNotifications->email_update_schedule ? 'mail' : ''];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('Your schedule was be updated')
                    ->action('Open page', url('/team/'.$this->schedule->team->name.'/schedule'))
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
            'title' => 'Your schedule was be updated',
            'body' => $this->schedule->title.' '.$this->schedule->start_date.' - '.$this->schedule->end_date,
            'url' => url('/team/'.$this->schedule->team->name.'/schedule'),
        ];
    }
}
