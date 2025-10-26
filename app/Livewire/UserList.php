<?php

namespace App\Livewire;

use App\Models\Message;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class UserList extends Component
{
    public $search = '';

    public $current_messages = [];

    public $error_message = '';

    public $input_message = '';

    public $current_partner_id = '';

    public function mount()
    {
        $this->reset('current_messages');
    }

    public function start_new_chat()
    {
        $this->error_message = '';
        $username = $this->search;

        if ($username === '') {
            return;
        }
        $user = User::where('username', $username)->first();
        if (!$user) {
            $this->error_message = "Username not found.";
            return;
        }

        $new_message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $user->id,
            'message' => 'Halo',
        ]);

        $this->show_chat($user->id);
        $this->render();
    }

    public function sent_message()
    {
        if ($this->input_message == '') {
            return;
        }

        $new_message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $this->current_partner_id,
            'message' => $this->input_message,
        ])->load('sender');
        $this->current_messages->push($new_message);
        $this->input_message = '';
    }

    public function show_chat($sender_id)
    {
        if (!$sender_id)
            return;
        $this->current_partner_id = $sender_id;
        $this->reset('current_messages');

        $this->current_messages = Message::with('sender')
            ->where(function ($q) use ($sender_id) {
                // Pesan yang dikirim ke user login
                $q->where('receiver_id', Auth::id())
                    ->where('sender_id', $sender_id);
            })
            ->orWhere(function ($q) use ($sender_id) {
                // Pesan yang dikirim oleh user login
                $q->where('sender_id', Auth::id())
                    ->where('receiver_id', $sender_id);
            })
            ->get()
            ->sort();

    }


    public function render()
    {

        return view('livewire.user-list', [
            'chats' => Message::with(['sender', 'receiver'])
                ->where(function ($q) {
                    $q->where('receiver_id', Auth::id())
                        ->whereHas(
                            'sender',
                            fn($q) =>
                            $q->where('username', 'like', "%{$this->search}%")
                        );
                })
                ->orWhere(function ($q) {
                    $q->where('sender_id', Auth::id())
                        ->whereHas(
                            'receiver',
                            fn($q) =>
                            $q->where('username', 'like', "%{$this->search}%")
                        );
                })
                ->orderBy('created_at')
                ->get()
                ->groupBy(fn($msg) => $msg->sender_id == Auth::id() ? $msg->receiver_id : $msg->sender_id),
        ]);

    }
}
