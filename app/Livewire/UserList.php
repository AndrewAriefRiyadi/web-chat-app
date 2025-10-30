<?php

namespace App\Livewire;

use App\Models\Message;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use App\Events\MessageSent;

class UserList extends Component
{
    public $search = '';

    public $current_messages = [];

    public $error_message = '';

    public $input_message = '';

    public $current_partner_id = '';

    public $userId;

    public $new_messages_notif = []; //sender->id yang masuk pesan baru


    public function mount()
    {
        $this->reset('current_messages');
        $this->userId = Auth::id();
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

        Message::create([
            'sender_id' => $this->userId,
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
            'sender_id' => $this->userId,
            'receiver_id' => $this->current_partner_id,
            'message' => $this->input_message,
        ])->load('sender');
        $this->current_messages->push($new_message);
        $this->input_message = '';

        broadcast(new MessageSent($new_message))->toOthers();

    }
    #[On('echo-private:chat.{userId},MessageSent')]
    public function message_received($data)
    {
        $message = $data['message'];
        if ($message['receiver_id'] != $this->userId) {
            return;
        }

        if ($this->current_partner_id == $message['sender_id']) {
            $new_message = Message::find($message['id']);
            $this->current_messages->push($new_message);
            return;
        }
        if (in_array($message['sender_id'], $this->new_messages_notif)) {
            return;
        }
        array_push($this->new_messages_notif, $message['sender_id']);
    }

    public function show_chat($sender_id)
    {
        if (!$sender_id)
            return;
        $this->current_partner_id = $sender_id;
        $this->reset('current_messages');

        $key = array_search($sender_id, $this->new_messages_notif); // Find the key of the first occurrence
        if ($key !== false) {
            unset($this->new_messages_notif[$key]); // Remove the element at the found key
        }

        $this->current_messages = Message::with('sender')
            ->where(function ($q) use ($sender_id) {
                // Pesan yang dikirim ke user login
                $q->where('receiver_id', $this->userId)
                    ->where('sender_id', $sender_id);
            })
            ->orWhere(function ($q) use ($sender_id) {
                // Pesan yang dikirim oleh user login
                $q->where('sender_id', $this->userId)
                    ->where('receiver_id', $sender_id);
            })
            ->get()
            ->sort();
    }


    public function render()
    {
        $userId = $this->userId;
        return view('livewire.user-list', [
            'chats' => Message::with(['sender', 'receiver'])
                ->where(function ($q) use ($userId) {
                    $q->where('receiver_id', $userId)
                        ->orWhere('sender_id', $userId);
                })
                ->when($this->search, function ($q) {
                    $q->whereHas('sender', fn($q) => $q->where('username', 'like', "%{$this->search}%"))
                        ->orWhereHas('receiver', fn($q) => $q->where('username', 'like', "%{$this->search}%"));
                })
                ->orderByDesc('created_at')
                ->get()
                ->groupBy(fn($msg) => $msg->sender_id == $userId ? $msg->receiver_id : $msg->sender_id),
        ]);
    }
}
