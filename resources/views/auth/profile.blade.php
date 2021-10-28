@extends('layouts.app')
@section('title', 'Edit profile')
@section('content')
    <edit-from :user="{{ json_encode($user) }}" destroy-route="{{ $destroyRoute }}"></edit-from>
@endsection
