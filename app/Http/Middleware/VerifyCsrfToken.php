<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

use Closure;

class VerifyCsrfToken extends Middleware
{
    public function handle($request, Closure $next)
    {
        if (env('APP_ENV') == 'testing') return $next($request);

        return parent::handle($request, $next);
    }
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //
    ];
}
