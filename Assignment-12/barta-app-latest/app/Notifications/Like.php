<?php

namespace App\Notifications;

use App\Models\Post;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class Like extends Notification
{
    use Queueable;

    public Post $post;
    public User $author;

    /**
     * Create a new notification instance.
     */
    public function __construct($post,$author)
    {
        $this->post = $post;
        $this->author = $author;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->greeting('Hello, '.$this->author->full_name)
            ->line(auth()->user()->full_name.' reacted your post.')
            ->action('View the post', route('post.single', $this->post->uuid))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'resource_id' => $this->post->id
        ];
    }
}
