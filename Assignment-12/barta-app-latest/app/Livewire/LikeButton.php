<?php

namespace App\Livewire;

use App\Models\React;
use App\Models\User;
use App\Notifications\Like;
use Livewire\Component;
use App\Models\Post;
use Livewire\Attributes\Reactive;
use App\Events\Like as LiveEvent;

class LikeButton extends Component
{

    #[Reactive]

    public Post $post;

    public function toggleLike()
    {
        $user = auth()->user();
        $reactData = React::where('user_id',$user->id)->where('post_id',$this->post->id)->first();

        //  $author = User::where('id',$this->post->user_id)->first();

        if ($reactData) {

            React::where('id', $reactData->id)->delete();

        } else {

           $react = React::create([
                'user_id' => $user->id,
                'post_id' => $this->post->id,
                'react_yn' => 'Y',
            ]);

            event(new LiveEvent($react));
        }

        if ($user->hasLiked($this->post)) {
            $user->likes()->detach($this->post);
        } else {
            $user->likes()->attach($this->post);
            //$author->notify(new Like($this->post,$author));
        }
    }

    public function render()
    {
        return view('livewire.like-button');
    }
}
