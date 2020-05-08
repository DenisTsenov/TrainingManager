@extends('layouts.app')
@section('title') Login @endsection
@section('content')
    @if (session('logout'))
        <div class="alert alert-success mt-3">
            {{ session('logout') }}
        </div>
    @endif
    <login-form></login-form>
@endsection