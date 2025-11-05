<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\On;

class Notifications extends Component
{
    
    public $current_notifications = [];

    public $userId;

    public function mount(){
        $this->userId = Auth::id();
    }

    #[On('echo-private:chat.{userId},MessageSent')]
    public function show_notif($data){
        $message = $data['message'];
        if ($message['receiver_id'] != $this->userId) {
            return;
        }
        $partner = User::findOrFail($message['sender_id']);
        $notif = 'You got a new message from '. $partner->username;
        array_push($this->current_notifications,$notif);

        $this->dispatch('notif_shown');
    }

    #[On('remove_notif')]
    public function remove_notif(){
        array_shift($this->current_notifications);
    }
    public function render()
    {
        return view('livewire.notifications');
    }
}
