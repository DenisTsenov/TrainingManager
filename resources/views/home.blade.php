@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <br>
    @admin
        <distribute-competitors><distribute-competitors>
    @endadmin

    @if(\Illuminate\Support\Facades\Auth::user()->doesntHave('membership')->get())
        <div class="text-info text-center">You are still not distributed for a team</div>
    @endif
@endsection
