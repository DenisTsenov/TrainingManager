<div id="logout">
    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #00ff99;"> <!-- temporary color style-->
        @guest
            <a class="navbar-brand btn btn-light btn-sm text-muted" href="{{ route('login.show') }}">Login</a>
            <a class="navbar-brand btn btn-light btn-sm text-muted" href="{{ route('register.show') }}">Register</a>
        @endguest
        @auth
            <a class="navbar-brand btn btn-light text-muted" href="{{ route('welcome') }}">Home</a>
            <ul class="navbar-nav bg-primary rounded">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle btn-light rounded" href="#" id="navbarDropdownMenuLink"
                       data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false">
                        <i class="far fa-user-circle"></i><span class="h5"> Profile</span>
                    </a>
                    <div class="dropdown-menu text-left" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item btn btn-light" href="{{ route('profile.edit') }}">
                            <i class="fas fa-edit"></i>Edit
                        </a>
                        <a class="dropdown-item btn btn-light" v-on:click="logout">
                            <i class="fas fa-sign-out-alt"></i>Logout
                        </a>
                    </div>
                </li>
            </ul>
            <span class="badge badge-danger" v-if="serverErr">Something went wrong</span>
        @endauth
    </nav>
</div>

@auth
    @push('scripts')
        <script type="text/javascript">
            new Vue({
                el: '#logout',
                data: {
                    serverErr: false,
                    loaded: true,
                },
                methods: {
                    logout: function (event) {
                        if (this.loaded) {
                            this.loaded = false;
                            axios.post('/logout', {}).then(
                                response => {
                                    window.location = response.data.route;
                                }
                            ).catch(error => {
                                if (error.length) {
                                    this.serverErr = true;
                                }
                            });
                        }
                    }
                }
            });
        </script>
    @endpush
@endauth
