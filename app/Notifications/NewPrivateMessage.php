<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\User;

use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;

class NewPrivateMessage extends Notification implements ShouldBroadcast
{
    use Queueable;

    public $toNotify;
    public $sender;
    public $conversation_id;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($toNotify, User $sender, $conversation_id)
    {
        $this->toNotify = $toNotify;
        $this->sender = $sender;
        $this->conversation_id = $conversation_id;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable): array
    {
        // in order of execution
        return ['database', 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    // public function toMail($notifiable)
    // {
    //     return (new MailMessage)
    //                 ->line('The introduction to the notification.')
    //                 ->action('Notification Action', url('/'))
    //                 ->line('Thank you for using our application!');
    // }

    // broadcast user's unread notifications
    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'count' => $notifiable->unreadNotifications()->where('data->conversation_id', '=', $this->conversation_id)->count(),
            'data' =>  $notifiable->unreadNotifications->first()
        ]);
    }

    // save to 'notifications' table
    public function toArray($notifiable)
    {
        return [
            'to' => $notifiable->id,
            'from' => $this->sender->id,
            'conversation_id' => $this->conversation_id,
        ];
    }
}
