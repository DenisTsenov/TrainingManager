@extends('layouts.app')
@section('title', 'Settlements')
@section('content')
    <create-edit-settlement :settlement-edit='@json($settlement ?? null)'
                            action-type="{{ isset($settlement) ? 'Edit' : 'Create' }}"
                            route="{{ $route }}">
    </create-edit-settlement>
@endsection
