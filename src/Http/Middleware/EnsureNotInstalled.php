<?php

namespace Canvas\Http\Middleware;

use Auth;
use Closure;
use Canvas\Helpers\SetupHelper;

class EnsureNotInstalled
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (SetupHelper::isInstalled()) {
            return redirect('/');
        }

        return $next($request);
    }
}
