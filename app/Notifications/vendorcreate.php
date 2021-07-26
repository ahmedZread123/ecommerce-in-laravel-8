<?php

namespace App\Notifications;

use App\Models\vendor;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class vendorcreate extends Notification
{
    use Queueable;


    public $vendor ;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(vendor $vendor)
    {
        $this->vendor = $vendor;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $subject = sprintf('لقد تم انشاء حسابكم في المتجر الاكتروني ' , config('app.name') ,'المتجر الاكتروني ') ;
        $greeting = sprintf('مرحبا' , $notifiable->name);

        return (new MailMessage)
                    ->subject($subject)
                    ->greeting($greeting)
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
            //
        ];
    }
}
