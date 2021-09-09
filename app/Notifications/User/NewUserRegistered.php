<?php

namespace App\Notifications\User;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Models\User;

class NewUserRegistered extends Notification implements ShouldBroadcast
{
    use Queueable;

    public User $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
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
        $route = route('admin.distribute.create', ['user' => $this->user->id]);

        return new BroadcastMessage([
            'message' => view('auth.admin.notifications.registered_user', compact('route'))->render(),
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
            ->line('User name: ' . $this->user->full_name)
            ->line('Settlement: ' . $this->user->settlement->name)
            ->line('Sport: ' . $this->user->sport->name)
            ->action('Show user', route('admin.distribute.create', ['user' => $this->user->id]));
    }
}
