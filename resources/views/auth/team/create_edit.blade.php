@extends('layouts.app')
@section('title', 'Create team')
@section('content')
    <create-edit-team :team='@json($team ?? null)'
                      action-type="{{ isset($team) ? 'Edit' : 'Create' }}"
                      edit="{{ $edit ?? false }}"
                      route="{{ $route }}">
    </create-edit-team>
@endsection
