<?php

use Illuminate\Support\Facades\Gate;

if (!function_exists('can')) {
    function can($permission)
    {
        return Gate::allows($permission, \Auth::user());
    }
}

if (!function_exists('cannot')) {
    function cannot($permission)
    {
        return !can($permission, \Auth::user());
    }
}
