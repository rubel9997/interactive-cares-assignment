<?php

namespace App\Livewire;

use App\Models\User;
use App\Notifications\Like;
use Livewire\Component;
use App\Models\Post;
use Livewire\Attributes\Reactive;

class LikeButton extends Component
{

    #[Reactive]

    public Post $post;

    public function toggleLike()
    {
        $user = auth()->user();

      //  $author = User::where('id',$this->post->user_id)->first();

        if ($user->hasLiked($this->post)) {
            $user->likes()->detach($this->post);
        } else {
            $user->likes()->attach($this->post);
         //   $author->notify(new Like($this->post,$author));
        }
    }

    public function render()
    {
        return view('livewire.like-button');
    }
}
