<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsCompany
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->user_type == "company") {
            return $next($request);
        }
        return abort(403, 'This page can not be accessed.');
//        return redirect()->route('company.login')->with('error', "You don't have company access.");
    }
}
