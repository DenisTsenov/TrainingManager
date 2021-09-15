@extends('layouts.app')
@section('title', 'Create team')
@section('content')
    <br>
    @can('create', \App\Models\Admin\Team::class)
        <a class="btn btn-success btn-xl mb-3 text-white" href="{{ $route }}">New team</a>
    @else
        <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="There are no free trainers.">
            <button class="btn btn-success btn-xl mb-3 text-white" disabled>New team</button>
        <span>
    @endcan
    <team-list></team-list>
@endsection
