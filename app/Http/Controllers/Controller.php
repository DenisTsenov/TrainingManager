<?php

namespace App\Http\Controllers;

use Illuminate\Support\Collection;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\View;

class Controller extends BaseController
{
    const MENU_LOGIN    = 'login';
    const MENU_REGISTER = 'register';
    const MENU_WELCOME  = 'welcome';

    const MENU_PROFILE          = 'profile';
    const SUB_MENU_EDIT_PROFILE = 'edit-profile';
    const SUB_MENU_HISTORY      = 'history';

    const MENU_ADMIN                             = 'admin';
    const SUB_MENU_MANAGE_USER_ROLES_PERMISSIONS = 'manage-user-roles';
    const SUB_MENU_MANAGE_ROLE_PERMISSIONS       = 'manage-role-permissions';
    const SUB_MENU_TEAM                          = 'team';
    const SUB_MENU_SETTLEMENTS                   = 'settlements';
    const SUB_MENU_SETTLEMENTS_LIST              = 'settlements-list';
    const SUB_MENU_SETTLEMENT_CREATE_EDIT        = 'settlement-create-edit';
    const SUB_MENU_SPORTS                        = 'sports';
    const SUB_MENU_SPORTS_LIST                   = 'sports-list';
    const SUB_MENU_SPORT_CREATE_EDIT             = 'sport-create-edit';

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @var string
     */
    protected string $activeMenu = '';

    /**
     * @var ?Collection
     */
    public ?Collection $activeSubMenu = null;

    public function __construct()
    {
        $this->activeSubMenu = collect();

        View::composer('layouts.partials._nav', function ($view) {
            $view->with('activeMenu', $this->getActiveMenu())
                 ->with('activeSubMenu', $this->getActiveSubMenu());
        });
    }

    /**
     * @return string
     */
    public function getActiveMenu(): string
    {
        return $this->activeMenu;
    }

    /**
     * @param string $activeMenu
     */
    public function setActiveMenu(string $activeMenu): void
    {
        $this->activeMenu = $activeMenu;
    }

    public function setActiveSubMenu(string ...$activeSubMenu): void
    {
        $this->activeSubMenu->push($activeSubMenu);
    }

    /**
     * @return ?Collection
     */
    public function getActiveSubMenu(): ?Collection
    {
        return $this->activeSubMenu->flatten();
    }
}
