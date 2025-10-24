<div>
    <div class=" flex flex-col gap-2 mb-2">
        <p class=" text-xl">Chats</p>
        <input wire:model.live="search" type="text" placeholder="username.."
            class=" bg-white/10 p-2   text-xs rounded placeholder:text-white/50 focus:outline-none ">
        @if ($chats->isEmpty())
            <button class=" bg-accent/30 text-xs px-1  rounded py-2">Start new chat</button>
        @endif
        
    </div>
    <div class="flex flex-col gap-2 ">
        @if ($chats)
            @foreach ($chats as $senderId => $messages)
                {{-- Ambil pesan pertama untuk dapat info sender --}}
                @php $lastMessage = $messages->last(); @endphp
                <div class=" px-2 py-1 bg-primary/30 rounded w-full transition transform hover:translate-x-1">
                    <p class=" text-accent font-bold text-lg">{{ $lastMessage->sender->username }}</p>
                    <p class=" text-xs text-white/70 truncate">{{ $lastMessage->message }}</p>
                </div>
            @endforeach
        @endif
    </div>



</div>
