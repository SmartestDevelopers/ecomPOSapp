<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminMiddleware
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
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = DB::table('users')->where('id', Auth::id())->first();
        
        if (!$user || $user->role !== 'admin') {
            abort(403, 'Access denied. Admin privileges required.');
        }

        return $next($request);
    }
}
