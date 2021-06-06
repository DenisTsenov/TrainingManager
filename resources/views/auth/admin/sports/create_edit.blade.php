@extends('layouts.app')
@section('title', 'Create sport')
@section('content')
    <create-edit-sport :sport-edit='@json($sport ?? null)'
                       action-type="{{ isset($sport) ? 'Edit' : 'Create' }}"
                       route="{{ $route }}">
    </create-edit-sport>
@endsection
