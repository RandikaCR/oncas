<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class isAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    private $allowedUserRoles = ['019f4500-79ad-7075-8737-1c881b93367f', '019f4500-93c4-7386-9d2c-abbca3324a0a'];

    public function handle(Request $request, Closure $next): Response
    {
        if ( !empty(Auth::check()) && in_array(Auth::user()->user_role_id, $this->allowedUserRoles) ) {
            return $next($request);
        }else{
            return redirect()->back();
        }
    }
}
