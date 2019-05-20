<?php

namespace App\Notifications\Team;

use App\Services\SmsService;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NotifNewActivity extends Notification implements ShouldQueue
{
    use Queueable;


    private $activity;
    private $user;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($activity, $user)
    {
        $this->activity = $activity;
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        $types = [];
        array_push($types, 'database');

        if(!is_null($this->user->settingNotifications))
            if($this->user->settingNotifications->email_new_activity)
                array_push($types, 'mail');

        //Send sms notification
        if(!is_null($this->user->settingNotifications))
            if($this->user->settingNotifications->sms_new_activity)
                SmsService::sendSmsNotification($this->user->getPhone(), 'SE-IIB, New activity was created');

        return $types;
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
            'body' => 'In your team was created new activity. '.$this->activity->name,
            'url' => url('/team/'.$this->activity->team->name.'/activity/'.$this->activity->discipline->name),
        ];
    }
}
