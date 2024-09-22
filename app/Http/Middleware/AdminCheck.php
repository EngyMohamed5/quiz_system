<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next)
    {
       
        if (Auth::check()) {
            $user = Auth::user();
            if (Auth::check()  && $user->role === 'admin'||$user->role === 'super_admin') {
                return $next($request);
            }
        }
        return redirect()->back();
    }
}
