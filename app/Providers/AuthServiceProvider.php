<?php

namespace App\Providers;

use App\Models\Admin\Permission;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Telescope\ExceptionContext;
use Laravel\Telescope\IncomingExceptionEntry;
use Laravel\Telescope\Telescope;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        try {
            $permissions = Permission::pluck('name', 'id');
            foreach ($permissions as $id => $name) {
                Gate::define($name, function ($user) use ($id) {
                    if ($user->is_admin) return true;
                    if (!$user->role_id) return false;

                    return $user->role->permissions->contains($id);
                });
            }
        } catch (\Exception $exception) {
            Telescope::recordException(IncomingExceptionEntry::make($exception, [
                'class'        => get_class($exception),
                'file'         => $exception->getFile(),
                'line'         => $exception->getLine(),
                'message'      => $exception->getMessage(),
                'trace'        => $exception->getTrace(),
                'line_preview' => ExceptionContext::get($exception),
            ])->tags(['ServiceProvider:Auth']));
        }

        Gate::define('distributedUser', fn(User $user) => is_null($user->team_id));
    }
}
