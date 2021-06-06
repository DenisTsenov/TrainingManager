@extends('layouts.app')
@section('title', 'Sports list')
@section('content')
    <br>
    <sport-list :url="{{ json_encode($route) }}"></sport-list>
@endsection
