@extends('layouts.app')

@section('content')
    <div class=" flex justify-between mb-4">
        <div class=" flex">
            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                <path fill-rule="evenodd"
                    d="M12 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm-2 9a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-1a4 4 0 0 0-4-4h-4Z"
                    clip-rule="evenodd" />
            </svg>
            <p>{{ $user->username }} </p>
        </div>
        <a href="{{ route('logout') }}" class=" py-1 px-2 bg-accent/30 rounded-xl hover:bg-accent/10">Logout➡️</a>
    </div>
    
    <livewire:user-list />
@endsection
