<?php

namespace App\Notifications\Team;

use App\Services\SmsService;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NotifNewSchedule extends Notification
{
    use Queueable;

    private $schedule;
    private $user;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($schedule, $user)
    {
        $this->schedule = $schedule;
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
            if($this->user->settingNotifications->email_update_schedule)
                array_push($types, 'mail');


        //Send sms notification
        if(!is_null($this->user->settingNotifications))
            if($this->user->settingNotifications->sms_update_schedule)
                SmsService::sendSmsNotification($this->user->getPhone(), 'SE-IIB, Your schedule was updated');

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
//        return (new MailMessage)
//                    ->line('Your schedule was updated')
//                    ->action('Open page', url('/team/'.$this->schedule->team->name.'/schedule'))
//                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
//        return [
//            'title' => 'Your schedule was be updated',
//            'body' => $this->schedule->title.' '.$this->schedule->start_date.' - '.$this->schedule->end_date,
//            'url' => url('/team/'.$this->schedule->team->name.'/schedule'),
//        ];
    }
}
