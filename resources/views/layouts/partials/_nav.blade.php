<div id="logout">
    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #00ff99;"> <!-- temporary color style-->
        @guest
            <a class="navbar-brand btn btn-light btn-sm text-muted" href="{{ route('login.show') }}">Login</a>
            <a class="navbar-brand btn btn-light btn-sm text-muted" href="{{ route('register.show') }}">Register</a>
        @endguest
        @auth
            <a class="navbar-brand btn btn-light" href="{{ route('welcome') }}">Home</a>
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
                            <li class="dropdown-item">
                                <a class="dropdown-item btn btn-light" href="{{ route('admin.manage_user_roles') }}">
                                    <i class="fas fa-users-cog"></i> Manage user role
                                </a>
                            </li>
                            <li class="dropdown-item">
                                <a class="dropdown-item btn btn-light"
                                   href="{{ route('admin.manage_role_permission') }}">
                                    <i class="fas fa-tasks"></i> Manage role permission
                                </a>
                            </li>
                            <li class="dropdown-item">
                                <a class="dropdown-item btn btn-light" href="{{ route('admin.team') }}">
                                    <i class="fas fa-users"></i> Teams
                                </a>
                            </li>
                            <li class="dropdown-submenu">
                                <a class="dropdown-item btn btn-light  ml-4" tabindex="-1" href="#">
                                    <i class="fas fa-city"></i> Settlements
                                </a>
                                <ul class="dropdown-menu">
                                    <a class="dropdown-item btn btn-light" href="{{ route('admin.settlement.create') }}">
                                        <i class="fas fa-plus"></i> Add
                                    </a>
                                    <a class="dropdown-item btn btn-light" href="{{ route('admin.settlement') }}">
                                        <i class="fas fa-list"></i> List
                                    </a>
{{--                                    <li class="dropdown-submenu">--}}
{{--                                        <a class="dropdown-item" href="#">Even More..</a>--}}
{{--                                        <ul class="dropdown-menu">--}}
{{--                                            <li class="dropdown-item"><a href="#">3rd level</a></li>--}}
{{--                                            <li class="dropdown-submenu"><a class="dropdown-item" href="#">another--}}
{{--                                                    level</a>--}}
{{--                                                <ul class="dropdown-menu">--}}
{{--                                                    <li class="dropdown-item"><a href="#">4th level</a></li>--}}
{{--                                                    <li class="dropdown-item"><a href="#">4th level</a></li>--}}
{{--                                                    <li class="dropdown-item"><a href="#">4th level</a></li>--}}
{{--                                                </ul>--}}
{{--                                            </li>--}}
{{--                                            <li class="dropdown-item"><a href="#">3rd level</a></li>--}}
{{--                                        </ul>--}}
{{--                                    </li>--}}

                                </ul>
                            </li>

                            <li class="dropdown-submenu">
                                <a class="dropdown-item btn btn-light  ml-4" tabindex="-1" href="#">
                                    <i class="fas fa-table-tennis"></i> Sports
                                </a>
                                <ul class="dropdown-menu">
                                    <a class="dropdown-item btn btn-light" href="{{ route('admin.sport.create') }}">
                                        <i class="fas fa-plus"></i> Add sport
                                    </a>
                                    <a class="dropdown-item btn btn-light" href="{{ route('admin.sport') }}">
                                        <i class="fas fa-list"></i> List
                                    </a>
                                    {{--                                    <li class="dropdown-submenu">--}}
                                    {{--                                        <a class="dropdown-item" href="#">Even More..</a>--}}
                                    {{--                                        <ul class="dropdown-menu">--}}
                                    {{--                                            <li class="dropdown-item"><a href="#">3rd level</a></li>--}}
                                    {{--                                            <li class="dropdown-submenu"><a class="dropdown-item" href="#">another--}}
                                    {{--                                                    level</a>--}}
                                    {{--                                                <ul class="dropdown-menu">--}}
                                    {{--                                                    <li class="dropdown-item"><a href="#">4th level</a></li>--}}
                                    {{--                                                    <li class="dropdown-item"><a href="#">4th level</a></li>--}}
                                    {{--                                                    <li class="dropdown-item"><a href="#">4th level</a></li>--}}
                                    {{--                                                </ul>--}}
                                    {{--                                            </li>--}}
                                    {{--                                            <li class="dropdown-item"><a href="#">3rd level</a></li>--}}
                                    {{--                                        </ul>--}}
                                    {{--                                    </li>--}}

                                </ul>
                            </li>
                            <li class="dropdown-item">
                                <a class="dropdown-item disabled btn btn-light" href="#">
                                    <i class="fas fa-sheqel"></i> Add sport to settlement
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
