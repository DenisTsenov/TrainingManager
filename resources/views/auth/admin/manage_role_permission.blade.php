@extends('layouts.app')

@section('title', 'User roles management')

@section('content')
    hi {{ \Illuminate\Support\Facades\Auth::user()->first_name }}

    @foreach($permissions as $permission)
        {{ $permission->name }}
    @endforeach
@endsection
