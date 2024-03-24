
@extends('voyager::master')

@section('page_title', 'Show ' . $user->name)

@section('content')
    <h1>Show {{$user->name}}</h1>

    <div class="card" style="margin-bottom: 10px;">
        <div class="card-body">
            <h5 class="card-title">ID: {{ $user->id }}</h5>
        </div>
    </div>
    <div class="card" style="margin-bottom: 10px;">
        <div class="card-body">
            <h5 class="card-title">Name: {{ $user->name }}</h5>
        </div>
    </div>
    <div class="card" style="margin-bottom: 10px;">
        <div class="card-body">
            <h5 class="card-title">Email: {{ $user->email }}</h5>
        </div>
    </div>
    <div class="card" style="margin-bottom: 10px;">
        <div class="card-body">
            <h5 class="card-title">Telegram: {{ $user->telegram }}</h5>
        </div>
    </div>
    <div class="card" style="margin-bottom: 10px;">
        <div class="card-body">
            <h5 class="card-title">Balance: {{ $user->balance }} USDT</h5>
        </div>
    </div>
    <div class="card" style="margin-bottom: 10px;">
        <div class="card-body">
            <h5 class="card-title">Role: {{ $user->role->name }}</h5>
        </div>
    </div>
    <div class="card" style="margin-bottom: 10px;">
        <div class="card-body">
            <h5 class="card-title">Registered: {{ $user->created_at }}</h5>
        </div>
    </div>
@endsection