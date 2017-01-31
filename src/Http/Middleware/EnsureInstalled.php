<?php

namespace Canvas\Http\Middleware;

use Closure;

class EnsureInstalled
{
    /**
     * Handle an incoming request.
     * Since TravisCI does not allow for human interaction from
     * the CLI for canvas:install, we just make a hard redirect
     * to skip the installer.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        switch (env('APP_ENV') === 'testing') {
            case true:
                return redirect()->route('canvas.home');
            case false:
                return redirect()->route('canvas.install');
            default:
                return $next($request);
                break;
        }
    }
}
