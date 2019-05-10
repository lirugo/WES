<?php

namespace App\Notifications\Team;

use App\Services\SmsService;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NotifNewGroupWork extends Notification
{
    use Queueable;

    private $groupWork;
    private $user;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($groupWork, $user)
    {
        $this->groupWork = $groupWork;
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
            if($this->user->settingNotifications->email_new_group_work)
                array_push($types, 'mail');

        //Send sms notification
        if(!is_null($this->user->settingNotifications))
            if($this->user->settingNotifications->sms_new_group_work)
                SmsService::sendSmsNotification($this->user->getPhone(), 'SE-IIB, You have new group work');

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
            ->line('Created new group work')
            ->action('Open page', url('/team/'.$this->groupWork->team->name.'/group-work/'.$this->groupWork->discipline->name.'/'.$this->groupWork->id))
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
            'title' => 'Created new group work',
            'body' => $this->groupWork->name,
            'url' => url('/team/'.$this->groupWork->team->name.'/group-work/'.$this->groupWork->discipline->name.'/'.$this->groupWork->id),
        ];
    }
}
