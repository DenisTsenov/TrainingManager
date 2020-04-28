<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #00ff99;"> <!-- temporary color style-->
    @guest

        <a class="navbar-brand btn btn-light btn-sm text-muted" href="{{ route('login.show') }}">Login</a>
        <a class="navbar-brand btn btn-light btn-sm text-muted"  href="{{ route('register.show') }}">Register</a>
    @endguest
</nav>
