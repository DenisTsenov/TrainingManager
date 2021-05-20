@extends('layouts.app')
@section('title', 'Create team')
@section('content')
    <create-edit-form :team='@json($team ?? null)'
                      route="{{ $route ?? '' }}"
                      action-type="{{ isset($team) ? 'Edit' : 'Create' }}"></create-edit-form>
@endsection
