@extends('layouts.app')
@section('title', 'Login')
@section('content')
    @include('auth.messages.logout')
    <login-form></login-form>
@endsection
