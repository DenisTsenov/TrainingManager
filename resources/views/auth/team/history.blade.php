@extends('layouts.app')
@section('title', 'Team history')
@section('content')
    <team-history :team="{{ json_encode($team) }}"></team-history>
@endsection
