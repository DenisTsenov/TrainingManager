@extends('layouts.app')
@section('title', 'Create settlement')
@section('content')
<add-settlement :route="{{ json_encode(route('admin.settlement.store')) }}"></add-settlement>
@endsection
