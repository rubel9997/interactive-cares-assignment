<?php

namespace App\Livewire;

use App\Events\Like as LiveEvent;
use App\Models\React;
use App\Models\User;
use App\Notifications\Like;
use Livewire\Component;
use App\Models\Post as PostModel;
use Livewire\WithPagination;

class Post extends Component
{
    use WithPagination;

    public PostModel $post;
    public $per_page = 10;
    public bool $canLoadMore;

    public function mount(PostModel $post)
    {
        $this->post = $post;
    }

    public function render()
    {
        $posts = PostModel::with(['user', 'comments', 'viewCounts'])->latest()->paginate($this->per_page);
        $react = React::where('user_id', auth()->user()->id)->where('post_id', $this->post->id)->first();

        $this->canLoadMore = count($posts) >= $this->per_page;

        return view('livewire.post', ['posts' => $posts, 'react' => $react]);
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
        $author = User::where('id', $post->user_id)->first();

        if (!$post) {
            return;
        }

        $reactData = React::where('user_id', $user->id)->where('post_id', $postId)->first();

        if ($reactData) {
            React::where('id', $reactData->id)->delete();
        } else {
            React::create([
                'user_id' => $user->id,
                'post_id' => $post->id,
                'react_yn' => 'Y',
            ]);

            $author->notify(new Like($post));
        }

        if ($user->hasLiked($post)) {
            $user->likes()->detach($post);
        } else {
            $user->likes()->attach($post);
        }

    }
}
