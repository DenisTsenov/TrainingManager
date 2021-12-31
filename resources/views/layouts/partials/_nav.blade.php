<div id="logout">
    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #00ff99;"> <!-- temporary color style-->
        @guest
            <a class="navbar-brand btn btn-{{ $activeMenu == \App\Enums\Menu::LOGIN->value ? 'primary' : 'light' }} btn-sm"
               href="{{ route('login.show') }}">Login</a>
            <a class="navbar-brand btn btn-{{ $activeMenu == \App\Enums\Menu::REGISTER->value ? 'primary' : 'light' }} btn-sm"
               href="{{ route('register.show') }}">Register</a>
        @endguest
        @auth
            <a class="navbar-brand btn bg-{{ $activeMenu == \App\Enums\Menu::WELCOME->value ? 'primary': 'light'  }}"
               href="{{ route('welcome') }}">Home</a>
            <div class="dropdown">
                <a class="nav-link dropdown-toggle btn-{{ $activeMenu == \App\Enums\Menu::PROFILE->value ? 'primary' : 'light' }} rounded"
                   href="#" id="navbarDropdownMenuLink"
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="far fa-user-circle"></i><span class="h5"> Profile</span>
                </a>
                <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                    <li class="dropdown-item bg-{{ $activeSubMenu->contains(\App\Enums\Menu::SUB_MENU_EDIT_PROFILE->value) ? 'primary' : 'light' }}">
                        <a class="dropdown-item btn btn-light" href="{{ route('profile.edit') }}">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                    </li>
                    <li class="dropdown-item bg-{{ $activeSubMenu->contains(\App\Enums\Menu::SUB_MENU_HISTORY->value) ? 'primary' : 'light' }}">
                        <a class="dropdown-item btn btn-light" href="{{ route('profile.history_membership') }}">
                            <i class="fas fa-history"></i> History
                        </a>
                    </li>
                    <li class="dropdown-item">
                        <a class="dropdown-item btn btn-light" v-on:click="logout">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                    </li>
                </ul>
            </div>
            @admin
            <div class="dropdown ml-3">
                <a class="nav-link dropdown-toggle btn-{{ $activeMenu == \App\Enums\Menu::ADMIN->value ? 'primary' : 'light' }} rounded"
                   href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="far fa-user-circle"></i><span class="h5"> Admin</span>
                </a>
                <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                    <li class="dropdown-item bg-{{ $activeSubMenu->contains(\App\Enums\Menu::SUB_MENU_MANAGE_USER_ROLES_PERMISSIONS->value) ? 'primary' : 'light' }}">
                        <a class="dropdown-item btn btn-light"
                           href="{{ route('admin.manage_user_roles') }}">
                            <i class="fas fa-users-cog"></i> Manage user role
                        </a>
                    </li>

                    <li class="dropdown-item bg-{{ $activeSubMenu->contains(\App\Enums\Menu::SUB_MENU_MANAGE_ROLE_PERMISSIONS->value) ? 'primary' : 'light' }}">
                        <a class="dropdown-item btn btn-light"
                           href="{{ route('admin.manage_role_permission') }}">
                            <i class="fas fa-tasks"></i> Manage role permission
                        </a>
                    </li>

                    <li class="dropdown-item bg-{{ $activeSubMenu->contains(\App\Enums\Menu::SUB_MENU_TEAM->value) ? 'primary' : 'light' }}">
                        <a class="dropdown-item btn btn-light" href="{{ route('admin.team') }}">
                            <i class="fas fa-users"></i> Teams
                        </a>
                    </li>

                    <li class="dropdown-submenu">
                        <a class="dropdown-item btn bg-{{ $activeSubMenu->contains(\App\Enums\Menu::SUB_MENU_SETTLEMENTS->value) ? 'primary' : 'light' }}"
                           tabindex="-1" href="#">
                            <i class="fas fa-city ml-4"></i> Settlements
                        </a>
                        <ul class="dropdown-menu">
                            <a class="dropdown-item btn bg-{{ $activeSubMenu->contains(\App\Enums\Menu::SUB_MENU_SETTLEMENT_CREATE_EDIT->value) ? 'primary' : 'light' }}"
                               href="{{ route('admin.settlement.create') }}">
                                <i class="fas fa-plus"></i> Add
                            </a>
                            <a class="dropdown-item btn bg-{{ $activeSubMenu->contains(\App\Enums\Menu::SUB_MENU_SETTLEMENTS_LIST->value) ? 'primary' : 'light' }}"
                               href="{{ route('admin.settlement') }}">
                                <i class="fas fa-list"></i> List
                            </a>
                        </ul>
                    </li>

                    <li class="dropdown-submenu">
                        <a class="dropdown-item btn bg-{{ $activeSubMenu->contains(\App\Enums\Menu::SUB_MENU_SPORTS->value) ? 'primary' : 'light' }}"
                           tabindex="-1"
                           href="#">
                            <i class="fas fa-table-tennis ml-4"></i> Sports
                        </a>
                        <ul class="dropdown-menu">
                            <a class="dropdown-item btn bg-{{ $activeSubMenu->contains(\App\Enums\Menu::SUB_MENU_SPORT_CREATE_EDIT->value) ? 'primary' : 'light' }}"
                               href="{{ route('admin.sport.create') }}">
                                <i class="fas fa-plus"></i> Add
                            </a>
                            <a class="dropdown-item btn bg-{{ $activeSubMenu->contains(\App\Enums\Menu::SUB_MENU_SPORTS_LIST->value) ? 'primary' : 'light' }}"
                               href="{{ route('admin.sport') }}">
                                <i class="fas fa-list"></i> List
                            </a>
                        </ul>
                    </li>

                    <li class="dropdown-item">
                        <a class="dropdown-item" target="_blank" href="/laravel-websockets">
                            <i class="fas fa-magnet"></i> WebSockets Dashboard
                        </a>
                    </li>

                    <li class="dropdown-item">
                        <a class="dropdown-item" target="_blank" href="/telescope">
                            <i class="fab fa-tumblr"></i> Telescope
                        </a>
                    </li>
                </ul>
            </div>
            @endadmin
            @trainer
            <div class="dropdown ml-3">
                <a class="nav-link dropdown-toggle btn-light rounded" href="#"
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-users-cog"></i><span class="h5">Trainer</span>
                </a>
                <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                    <li class="dropdown-item">
                        <a class="dropdown-item btn btn-light" href="#">
                            <i class="fas fa-users"></i>My team list
                        </a>
                    </li>
                    <li class="dropdown-item">
                        <a class="dropdown-item btn btn-light" href="#">
                            <i class="fas fa-tasks"></i>Assigned trainings
                        </a>
                    </li>
                </ul>
            </div>
            @endtrainer
            @competitor
            <div class="dropdown ml-3">
                <li class="dropdown-submenu text-center">
                    <a class="dropdown-item" tabindex="-1" href="#"><i class="fas fa-user-shield"></i>Competitor</a>
                    <ul class="dropdown-menu">
                        <li class="dropdown-item">
                            <a class="dropdown-item btn btn-light" href="">
                                <i class="fas fa-user"></i>
                            </a>
                        </li>
                    </ul>
                </li>
            </div>
            @endcompetitor
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
