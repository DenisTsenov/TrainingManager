@extends('layouts.app')
@section('title', 'Create team')
@section('content')
    <create-edit-form :team='@json($team ?? null)'></create-edit-form>
@endsection
