@extends('layouts.app')
@section('title', 'Membership history')
@section('content')
    <membership-history :user="{{ json_encode($user) }}"></membership-history>
@endsection
