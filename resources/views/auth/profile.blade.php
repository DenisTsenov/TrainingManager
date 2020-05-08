@extends('layouts.app')
@section('title') Edit profile @endsection
@section('content')
    <div id="edit">
        <edit-profile-from :user="{{ json_encode(\Illuminate\Support\Facades\Auth::user()) }}"></edit-profile-from>
    </div>
@endsection
