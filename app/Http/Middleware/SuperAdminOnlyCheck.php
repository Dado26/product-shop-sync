<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class SuperAdminOnlyCheck
{
    /**
     * List of super admins
     *
     * @var array
     */
    private $superAdmins = ['vstruhar@gmail.com'];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (!Auth::check()) {
            return redirect('/');
        }

        if (!in_array(Auth::user()->email, $this->superAdmins)) {
            return redirect('/');
        }

        return $next($request);
    }
}
