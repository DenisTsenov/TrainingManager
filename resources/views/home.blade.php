@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <br>
    @admin
        <distribute-users-list><distribute-users-list>
    @else
        @can('distributedUser')
            <div class="text-info text-center">You are still not distributed for a team</div>
        @endcan
    @endadmin
@endsection
