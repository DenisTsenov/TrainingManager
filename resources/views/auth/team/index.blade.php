@extends('layouts.app')
@section('title', 'Create team')
@section('content')
    <br>
    <team-list :route='@json($route)'></team-list>
@endsection
