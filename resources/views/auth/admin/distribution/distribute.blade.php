@extends('layouts.app')

@section('title', 'Distribute')

@section('content')
    <br>
    <distribute-user
        :user="{{ json_encode($user) }}"
        :teams="{{ json_encode($teams) }}"
        :route="{{ json_encode($route) }}">
    <distribute-user>
@endsection
