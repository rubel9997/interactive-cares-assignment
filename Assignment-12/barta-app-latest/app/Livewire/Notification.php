<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;

class Notification extends Component
{
    public $notifications;


    public function mount()
    {
        $this->notifications = auth()->user()->unreadNotifications()->get();
    }

    #[On('echo:like-event,Like')]
    #[On('echo:comment-event,Comment')]

    public function refreshNotifications()
    {
        $this->notifications = auth()->user()->unreadNotifications()->get();
    }

    public function render()
    {
        return view('livewire.notification', ['notifications' => $this->notifications]);
    }

}
