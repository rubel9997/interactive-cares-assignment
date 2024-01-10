<?php

namespace App\Livewire;

use App\Events\Like as LikeEvent;
use App\Notifications\Like as LikeNotification;
use Livewire\Component;
use App\Models\Post as PostModel;
use Livewire\WithPagination;

class Post extends Component
{
    use WithPagination;

    public $per_page = 10;
    public bool $canLoadMore;


    public function render()
    {
        $posts = PostModel::with(['user', 'comments', 'viewCounts'])->latest()->paginate($this->per_page);

        $this->canLoadMore = count($posts) >= $this->per_page;

        return view('livewire.post', ['posts' => $posts]);
    }

    public function loadMore()
    {
        if (!$this->canLoadMore) {
            return null;
        }

        $this->per_page += 10;
    }

    public function toggleLike($postId)
    {
        $user = auth()->user();
        $post = PostModel::find($postId);

        if ($user->hasLiked($post)) {
            $user->likes()->detach($post);

            // Remove the like notification
            $notification = $post->user->notifications()
                ->where('type', LikeNotification::class)
                ->where('data->post_id', $post->id)
                ->first();

            if ($notification) {
                $notification->delete();
            }
        } else {
            $user->likes()->attach($post);

            $fullName = $user->full_name;
            $imagePath = $user->getFirstMediaUrl();

            event(new LikeEvent($post, $fullName, $imagePath));
            $post->user->notify(new LikeNotification($post, $fullName, $imagePath));
        }
    }

}
