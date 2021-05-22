@extends('layouts.app')
@section('title', 'Create team')
@section('content')
    <create-edit-form :team='@json($team ?? null)'
                      action-type="{{ isset($team) ? 'Edit' : 'Create' }}"
                      route="{{ $route }}">
    </create-edit-form>
@endsection
