<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>{{ config('app.name') }} @yield('title')</title>
    @include('layouts.partials._head')
</head>
<body>
    @include('layouts.partials._nav')
    <div id="app">
        @include('auth.messages.success')
        <div class="container">
            @admin
            <div class="row justify-content-center mt-3">
                <div class="alert alert-info collapse w-50 text-center" role="alert" id="notification"></div>
            </div>
            @endadmin
            @yield('content')
        </div>
    </div>
    @include('layouts.partials._footer')
</body>
</html>
@admin
<script type="application/javascript">
    $(document).ready(function () {
        Echo.private("App.Models.User.{{ Illuminate\Support\Facades\Auth::user()->id  }}")
            .notification((notification) => {
                attachNotification(notification.message);
            });

        function attachNotification(notification) {
            $('#notification').removeClass('collapse').html(notification);
        }
    });
</script>
@endadmin
