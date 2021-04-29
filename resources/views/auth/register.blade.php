@extends('layouts.app')
@section('title', 'Register')
@section('content')
    <register-form :settlements="{{ $settlements }}"></register-form>
@endsection
