<div
    class="absolute h-40 flex flex-col-reverse -top-1/3 right-0 min-w-1/2 max-w-1/2 p-4  text-white shadow-lg z-50 i overflow-clip gap-2">
    @foreach ($current_notifications as $notif)
        <div class=" outline-white/30 p-2 outline-1 rounded w-full bg-accent/50">
            <p>{{ $notif }}</p>
        </div>
    @endforeach

</div>

@script
    <script>
        $wire.on('notif_shown', () => {
            const myTimeout = setTimeout(() => {
                $wire.dispatch('remove_notif');
            }, 5000);
        });
    </script>
@endscript
