@extends('layouts.app')

@section('content')
    <div id="edit">
        <edit-profile-from :user="{{ json_encode($user) }}"></edit-profile-from>
    </div>
@endsection
