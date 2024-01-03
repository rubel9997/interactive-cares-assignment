<?php

namespace App\Livewire;

use App\Models\Comment;
use App\Models\Post;
use Livewire\Component;
use Livewire\Attributes\Reactive;

class LatestComment extends Component
{
    #[Reactive]

    public Post $post;
    public function render()
    {
        $comment = Comment::with('user','post')->where('post_id',$this->post->id)->latest()->first();

        return view('livewire.latest-comment',['comment'=>$comment]);
    }
}
