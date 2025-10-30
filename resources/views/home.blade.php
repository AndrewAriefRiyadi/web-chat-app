@extends('layouts.app')

@section('content')
    <div class=" flex justify-between mb-4">
        <p>Welcome {{$user->username}}</p>
        <a href="{{route('logout')}}">Logout</a>
    </div>
    <livewire:user-list/>
@endsection