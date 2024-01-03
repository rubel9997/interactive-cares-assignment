<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\On;

class Notification extends Component
{

    public $notification;

    public function render()
    {
        $this->notification = auth()->user()->notifications()->count();

        return view('livewire.notification',['notification'=>$this->notification]);
    }


    #[On('echo:live-event,Like')]
    public function likeEvent($event)
    {
        $this->notification = $event['react'];
    }

}
