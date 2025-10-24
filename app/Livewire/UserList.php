<?php

namespace App\Livewire;

use App\Models\Message;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class UserList extends Component
{
    public $search = '';

    public function render()
    {
        return view('livewire.user-list', [
            'chats' => Message::with('sender')
                ->where('reciever_id', Auth::id())
                ->whereHas('sender', fn($q) => $q->where('username', 'like', "%{$this->search}%"))
                ->get()
                ->groupBy('sender_id')
        ]);

    }
}
