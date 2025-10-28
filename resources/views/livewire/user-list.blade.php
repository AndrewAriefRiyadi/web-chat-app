<div class=" h-full w-full">
    <div class=" flex  min-h-92 gap-2  ">
        <div class=" h-full w-52 min-w-52 max-w-52 p-1 min-h-92  ">
            <div class=" flex flex-col gap-2 mb-2 w-full">
                <p class=" text-xl">Chats</p>
                <input wire:model.live="search" type="text" placeholder="username.."
                    class=" bg-white/10 p-2   text-xs rounded placeholder:text-white/50 focus:outline-2 outline-1 outline-white/30 ">
                @if ($chats->isEmpty())
                    <button wire:click="start_new_chat"
                        class=" bg-accent/30 text-xs px-1  rounded py-2 hover:bg-accent/50 focus:outline focus:outline-white/30">Start
                        new chat</button>
                @endif
                @if ($error_message)
                    <p class=" text-xs text-red-500">{{ $error_message }}</p>
                @endif

            </div>
            <div class="flex flex-col gap-2 w-full ">
                @if ($chats)
                    @foreach ($chats as $partnerId => $messages)
                        @php
                            // Ambil pesan terakhir untuk preview
                            $lastMessage = $messages->sortByDesc('created_at')->first();
                            // Tentukan user lawan bicara (bisa sender atau receiver)
                            $partner =
                                $lastMessage->sender_id == Auth::id() ? $lastMessage->receiver : $lastMessage->sender;
                            
                        @endphp

                        <button type="button" wire:click="show_chat({{ $partner->id }})"
                            class="text-start px-2 py-1 bg-primary/30 rounded w-full 
                                    transition transform hover:translate-x-1 
                                    focus:translate-x-1.5 focus:bg-secondary/30 
                                    focus:outline-2 focus:outline-white/30">

                            <p class="text-accent font-bold text-lg">
                                {{ $partner->username }}
                            </p>

                            <p class="text-xs text-white/70 truncate">
                                {{ $lastMessage->message }}
                            </p>
                        </button>
                    @endforeach
                @endif

            </div>
        </div>
        @if ($current_messages && $current_messages->isNotEmpty())
            <div
                class=" min-h-92 max-h-92 bg-white/10 outline-1 outline-white/30 p-2 w-full rounded flex flex-col gap-1 transition transform">
                <div class="h-full w-full overflow-scroll flex flex-col gap-1">
                    @foreach ($current_messages as $message)
                        @if ($message->sender_id == Auth::id())
                            <div class="w-1/2 self-end text-end flex justify-end">
                                <p class="bg-white/30 text-end  rounded-lg px-2 mr-2 py-1 w-fit self-end">
                                    {{ $message->message }}
                                </p>
                            </div>
                        @else
                            <div class="w-1/2">
                                <p class="bg-primary/30   rounded-lg px-2 py-1 w-fit ">
                                    {{ $message->message }}
                                </p>
                            </div>
                        @endif
                    @endforeach

                </div>
                <div class=" flex gap-2">
                    <input wire:model="input_message" value="{{ $input_message }}" wire:keydown.enter="sent_message"
                        type="text" class="w-full bg-white/10 py-1 px-2 focus:outline-0 rounded text-ellipsis">
                    <button wire:click="sent_message"
                        class="w-fit py-1 px-2 bg-accent/30 rounded hover:bg-accent/50 ">Sent</button>
                </div>
            </div>
        @endif
    </div>
</div>
