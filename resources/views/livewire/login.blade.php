<form wire:submit="save" class=" flex flex-col gap-2 ">
    <div class=" flex flex-col gap-2">
        <div class="text-center w-full">
            <p>Garis</p>
        </div>
        @if (session('success'))
            <div class="bg-green-600 text-white p-2 rounded mb-3">
                {{ session('success') }}
            </div>
        @endif

        <p class=" text-sm ">Username</p>
        <input type="text" wire:model.blur="username" class=" bg-white/10  rounded p-2">
        <div>
            @error('username')
                <span class="error text-xs text-red-400">{{ $message }}</span>
            @enderror
        </div>
        <p class=" text-sm">Password</p>
        <input type="password" wire:model.blur="password" class=" bg-white/10  rounded p-2">
        <div>
            @error('password')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <button type="submit" class=" bg-primary p-2 h-fit transition hover:bg-secondary ">Login</button>
    <p class=" text-center">Dont't have an account? <a href="{{ route('register') }}"
            class=" transition text-accent hover:underline ">Register</a></p>
</form>
