@extends('layouts.app')

@section('title', 'User roles management')

@section('content')
    <div id="roles">
        <search-field :roles="{{ $roles }}"></search-field>
    </div>
@endsection
