<?php

namespace App\Notifications;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class Like extends Notification
{
    use Queueable;

    public Post $post;
    public string $userName;
    public string $userImage;

    /**
     * Create a new notification instance.
     */
    public function __construct(Post $post, $full_name, $userImage)
    {
        $this->post = $post;
        $this->userName = $full_name;
        $this->userImage = $userImage;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->greeting('Hello, '.$notifiable->full_name)
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
            'post_id' => (string) $this->post->id,
            'message' => 'like_for_post',
            'link' => route('post.single',$this->post->uuid),
            'full_name'=> $this->userName,
            'user_image'=> $this->userImage,
        ];
    }
}
