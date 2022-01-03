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
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @var string
     */
    protected string $activeMenu = '';

    /**
     * @var Collection
     */
    public Collection $activeSubMenu;

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
     * @return Collection
     */
    public function getActiveSubMenu(): Collection
    {
        return $this->activeSubMenu->flatten();
    }
}
