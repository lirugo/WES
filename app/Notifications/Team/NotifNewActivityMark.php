<?php

namespace App\Notifications\Team;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NotifNewActivityMark extends Notification
{
    use Queueable;

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
        $types = [];
        array_push($types, 'database');

        if(!is_null($this->student->settingNotifications))
            if($this->student->settingNotifications->email_new_mark)
                array_push($types, 'mail');

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
                    ->line('User '. Auth()->user()->getShortName() .  ' get new mark')
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
            'title' => 'You have new mark',
            'body' => $this->activity->name.' your mark '.$this->activity->getMark($this->student->id)->mark,
            'url' => url('/team/'.$this->activity->team->name.'/activity/'.$this->activity->discipline->name.'/pass/'.$this->activity->id.'/'.$this->student->id),
        ];
    }
}
