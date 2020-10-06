<div id="logout">
    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #00ff99;"> <!-- temporary color style-->
        @guest
            <a class="navbar-brand btn btn-light btn-sm text-muted" href="{{ route('login.show') }}">Login</a>
            <a class="navbar-brand btn btn-light btn-sm text-muted" href="{{ route('register.show') }}">Register</a>
        @endguest
        @auth
            <a class="navbar-brand btn btn-light text-muted" href="{{ route('welcome') }}">Home</a>
            <div class="dropdown">
                <a class="nav-link dropdown-toggle btn-light rounded" href="#" id="navbarDropdownMenuLink"
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="far fa-user-circle"></i><span class="h5"> Profile</span>
                </a>
                <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                    <li class="dropdown-item">
                        <a class="dropdown-item btn btn-light" href="{{ route('profile.edit') }}">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                    </li>
                    <li class="dropdown-item">
                        <a class="dropdown-item btn btn-light" v-on:click="logout">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                    </li>
                    @admin
                    <li class="dropdown-divider"></li>
                    <li class="dropdown-submenu text-center">
                        <a class="dropdown-item" tabindex="-1" href="#"><i class="fas fa-user-shield"></i>Admin</a>
                        <ul class="dropdown-menu">
                            {{--                            <li class="dropdown-submenu">--}}
                            {{--                                <a class="dropdown-item" href="#">Even More..</a>--}}
                            {{--                                <ul class="dropdown-menu">--}}
                            {{--                                    <li class="dropdown-item"><a href="#">3rd level</a></li>--}}
                            {{--                                    <li class="dropdown-submenu"><a class="dropdown-item" href="#">another level</a>--}}
                            {{--                                        <ul class="dropdown-menu">--}}
                            {{--                                            <li class="dropdown-item"><a href="#">4th level</a></li>--}}
                            {{--                                            <li class="dropdown-item"><a href="#">4th level</a></li>--}}
                            {{--                                            <li class="dropdown-item"><a href="#">4th level</a></li>--}}
                            {{--                                        </ul>--}}
                            {{--                                    </li>--}}
                            {{--                                    <li class="dropdown-item"><a href="#">3rd level</a></li>--}}
                            {{--                                </ul>--}}
                            {{--                            </li>--}}
                            <li class="dropdown-item">
                                <a class="dropdown-item btn btn-light" href="{{ route('admin.manage.user.roles') }}">
                                    <i class="fas fa-users-cog"></i> Manage user role
                                </a>
                            </li>
                            <li class="dropdown-item">
                                <a class="dropdown-item btn btn-light" href="{{ route('admin.manage.role.permission') }}">
                                    <i class="fas fa-tasks"></i> Manage role permission
                                </a>
                            </li>
                        </ul>
                    </li>
                    @endadmin
                </ul>
            </div>
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