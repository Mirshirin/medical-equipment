<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckUserRole
{
    public function handle($request, Closure $next, ...$roles)
    {
        if (Auth::check() && in_array(Auth::user()->role->name, $roles)) {
            return $next($request); // کاربر دسترسی دارد
        }

        return redirect('/register')->with('error', 'دسترسی غیرمجاز.');
    }
}