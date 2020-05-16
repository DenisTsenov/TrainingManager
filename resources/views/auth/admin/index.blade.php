@extends('layouts.app')

@section('title', 'User roles management')

@section('content')
    <div class="row">
        <div class="col-8 offset-2">
            <search-field></search-field>
        </div>
    </div>
    <div class="row">
        <div class="col-8 offset-2">
            <roles-checkboxes :roles="{{ json_encode($roles) }}"></roles-checkboxes>
        </div>
    </div>
@endsection
