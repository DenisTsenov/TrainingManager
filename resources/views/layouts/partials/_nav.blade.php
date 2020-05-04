<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #00ff99;"> <!-- temporary color style-->
    @guest
        <a class="navbar-brand btn btn-light btn-sm text-muted" href="{{ route('login.show') }}">Login</a>
        <a class="navbar-brand btn btn-light btn-sm text-muted" href="{{ route('register.show') }}">Register</a>
    @endguest

    @auth
        <a class="navbar-brand btn btn-light btn-sm text-muted" href="">Profile</a>
        <span id="logout">
           <logout-button></logout-button>
       </span>
    @endauth
</nav>
@push('scripts')
    <script type="text/javascript">
        new Vue({
            el: '#logout',
            data: {},
        });
    </script>
@endpush