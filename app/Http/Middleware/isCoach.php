<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class isCoach
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    private $allowedUserRoles = ['019f4500-c2d9-7094-8fc8-1ced8e414519'];

    public function handle(Request $request, Closure $next): Response
    {
        if ( !empty(Auth::check()) && in_array(Auth::user()->user_role_id, $this->allowedUserRoles) ) {
            return $next($request);
        }else{
            return redirect()->back();
        }
    }
}
