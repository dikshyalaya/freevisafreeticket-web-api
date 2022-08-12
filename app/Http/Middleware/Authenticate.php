<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            $url = explode("/", $request->getRequestUri());
            if ($url[1] == "admin") {
                return route('admin.login');
            } else if ($url[1] == "company") {
                return route('company.login');
            } else if($url[1] == 'candidate'){
                return url('candidate/login');
            }
             else {
                return route('candidate.login');
            }
        }
    }
}
