<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;

class Notification extends Component
{
    use WithPagination;

    public $notifications;

    public function render()
    {
        $this->notifications = auth()->user()->notifications()->get();

        return view('livewire.notification', ['notifications' => $this->notifications]);
    }

    #[On('echo:live-event,Like')]
    public function likeEvent($event)
    {
        $this->notification = $event['react'];
    }

}
