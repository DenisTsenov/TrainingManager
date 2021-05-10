@extends('layouts.app')
@section('title', 'Create sport')
@section('content')
    <add-sport :route="{{ json_encode(route('admin.sport.store')) }}"></add-sport>
@endsection
