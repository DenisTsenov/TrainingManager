<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Styles -->
<link rel="stylesheet" href="{{ asset('css/app.css') }}"/>
@admin
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}"/>
@endadmin
@stack('styles')
