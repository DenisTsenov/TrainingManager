<?php

namespace App\Notifications\User;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewUserRegistered extends Notification implements ShouldBroadcast
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(public User $user)
    {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable): array
    {
        return ['mail', 'broadcast'];
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'message' => view('auth.admin.notifications.registered_user', [
                'route' => route('admin.distribute.create', ['user' => $this->user->id]),
            ])->render(),
        ]);
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param User $notifiable
     * @return MailMessage
     */
    public function toMail(User $notifiable): MailMessage
    {
        return (new MailMessage)
            ->from('denis@test.com')
            ->subject('New user registered')
            ->line("Hello $notifiable->full_name")
            ->line('New account was created.')
            ->line('User name: ' . $this->user->first_name . ' ' . $this->user->last_name)
            ->line('Settlement: ' . $this->user->settlement->name)
            ->line('Sport: ' . $this->user->sport->name)
            ->action('Show user', route('admin.distribute.create', ['user' => $this->user->id]));
    }
}
