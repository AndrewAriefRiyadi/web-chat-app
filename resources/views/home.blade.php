@extends('layouts.app')

@section('content')
    <div class=" text-center w-full mb-4">
        Welcome {{$user->username}}
    </div>
    <div class=" flex  min-h-96">
        <div class=" h-full min-w-52 p-1">
            <livewire:user-list/>
        </div>

        <div class="h-full bg-primary/20 p-1 w-full">
            isi chat
        </div>

    </div>
@endsection