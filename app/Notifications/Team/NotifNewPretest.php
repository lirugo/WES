<?php

namespace App\Notifications\Team;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NotifNewPretest extends Notification
{
    use Queueable;

    private $pretest;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($pretest)
    {
        $this->pretest = $pretest;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', Auth()->user()->settingNotifications->email_new_test ? 'mail' : ''];
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
                    ->line('Created new test')
                    ->action('Open page', url('/team/'.$this->pretest->team->name.'/pretest/discipline/'.$this->pretest->discipline->name))
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
            'title' => 'Created new test',
            'body' => 'In your team was be created new test. '.$this->pretest->name,
            'url' => url('/team/'.$this->pretest->team->name.'/pretest/discipline/'.$this->pretest->discipline->name),
        ];
    }
}
