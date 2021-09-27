@extends('layouts.app')

@section('title', 'User roles management')

@section('content')
    <div id="roles">
        <div class="row justify-content-center">
            <note text="{{ 'Only users without membership will be shown.' }}"></note>
        </div>
        <search-field :roles="{{ $roles }}"></search-field>
    </div>
@endsection
