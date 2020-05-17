@extends('layouts.app')

@section('title', 'User roles management')

@section('content')
    <div id="roles">
        <div class="row">
            <div class="col-8 offset-2">
                <search-field></search-field>
            </div>
        </div>
        <div class="row">
            <div class="col-8 offset-2 mt-5">
                <div class="card">
                    <div class="card-header">
                        <p class="h3 text-center">Roles</p>
                    </div>
                    <div class="card-body">
                        <roles-checkboxes :roles="{{ $roles }}"></roles-checkboxes>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
