<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Routing\Route;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode as Middleware;

class CheckForMaintenanceMode extends Middleware {

    /**
     * The URIs that should be reachable while maintenance mode is enabled.
     *
     * @var array
     */
    protected $except = [
        'admin/*',
    ];

    public function handle($request, Closure $next) {
        if ($this->app->isDownForMaintenance() && !$request->is('admin/*')) {
            throw new HttpException(503);
        }
        return $next($request);
    }

}
