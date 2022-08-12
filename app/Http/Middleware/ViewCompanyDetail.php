<?php

namespace App\Http\Middleware;

use App\Models\Employe;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ViewCompanyDetail
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
        if(Auth::check() && Auth::user()->user_type == 'candidate'){
            $candidate = Employe::where("user_id", Auth::user()->id)->first();
            $getCompaniesId = getApplicantCompanyList($candidate);
            if(in_array($request->id, $getCompaniesId)){
                return $next($request);
            } else {
                abort(403);
            }
        }
        return $next($request);
    }
}
