@extends('layouts.app')
@section('title', 'Settlements')
@section('content')
    <create-edit-settlement :settlement-edit='@json($settlement ?? null)'
                            action-type="{{ isset($settlement) ? 'Edit' : 'Create' }}"
                            route="{{ $route }}"
                            url="{{ $sportsUrl }}">
    </create-edit-settlement>
@endsection
