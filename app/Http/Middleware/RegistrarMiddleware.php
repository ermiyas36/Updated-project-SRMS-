<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegistrarMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        $allowedRoles = ['registrar', 'admin'];

        if (!in_array(Auth::user()->role, $allowedRoles, true)) {
            abort(403, 'Unauthorized access. Registrar only area.');
        }
        
        return $next($request);
    }
}