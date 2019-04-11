<?php

namespace App\Notifications\Team;

use App\Services\SmsService;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotifNewActivityMessage extends Notification
{
    use Queueable;

    private $activity;
    private $student;
    private $user;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($activity, $student, $user)
    {
        $this->activity = $activity;
        $this->student = $student;
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
            if($this->user->settingNotifications->email_new_activity_message)
                array_push($types, 'mail');


        //Send sms notification
        if(!is_null($this->user->settingNotifications))
            if($this->user->settingNotifications->sms_new_activity_message)
                SmsService::sendSmsNotification($this->user->getPhone(), 'SE-IIB, You have new message in activity');

        return $types;
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
            ->line('User '. Auth()->user()->getShortName() .  ' get new message in activity')
            ->action('Open page', url('/team/'.$this->activity->team->name.'/activity/'.$this->activity->discipline->name.'/pass/'.$this->activity->id.'/'.$this->student->id))
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
