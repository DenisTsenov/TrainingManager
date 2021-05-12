@extends('layouts.app')
@section('title', 'Create team')
@section('content')
<h1>Hello {{ $team->name ?? ''}}</h1>
@endsection
