<?php

use Illuminate\Support\Facades\Gate;

if (!function_exists('can')) {
    function can(int $id): bool
    {
        $permission = \App\Models\Admin\Permission::find($id)->name;
        return Gate::allows($permission);
    }
}

if (!function_exists('cannot')) {
    function cannot(int $id): bool
    {
        return !can($id);
    }
}
