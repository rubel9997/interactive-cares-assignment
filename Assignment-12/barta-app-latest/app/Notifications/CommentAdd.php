<?php

namespace App\Notifications;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CommentAdd extends Notification
{
    use Queueable;

    public User $author;
    public Comment $comment;
    public Post $post;
    public string $userName;
    public string $userImage;

    /**
     * Create a new notification instance.
     */
    public function __construct($author,$comment,$post,$full_name, $userImage)
    {
        $this->author = $author;
        $this->comment = $comment;
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
        return ['mail','database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->greeting('Hello, '.$this->author->full_name)
            ->line($notifiable->full_name.' commented on your post.')
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
            'message' => 'comment_for_post',
            'link' => route('post.single',$this->post->uuid),
            'full_name'=> $this->userName,
            'user_image'=> $this->userImage,
        ];
    }
}
