@extends('layouts.app')
@section('title', 'Edit profile')
@section('content')
    <edit-from :user="{{ json_encode(\Illuminate\Support\Facades\Auth::user()) }}"></edit-from>
@endsection
