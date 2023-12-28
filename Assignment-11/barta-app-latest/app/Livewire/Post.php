<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Post as PostModel;
use Livewire\WithPagination;

class Post extends Component
{
    use WithPagination;

    public $per_page = 10;

    public bool $canLoadMore;

    public function loadMore()
    {
        if(!$this->canLoadMore){
            return null;
        }

        $this->per_page += 10;
    }

    public function render()
    {
        $posts =PostModel::with(['user', 'comments', 'viewCounts', 'reactCounts'])->latest()->paginate($this->per_page);

        $this->canLoadMore = count($posts) >= $this->per_page;

        return view('livewire.post',['posts'=>$posts]);
    }

}
