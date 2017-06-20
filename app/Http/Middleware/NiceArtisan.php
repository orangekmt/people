<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Auth;

class NiceArtisan {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //$user = $request->user();

        if (Auth::user()->id == 1)
        {
            return $next($request);
        }
        return new RedirectResponse(url('/'));
    }

}
