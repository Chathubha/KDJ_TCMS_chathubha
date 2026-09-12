<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TeacherOnly
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || !in_array(auth()->user()->role, ['admin', 'teacher'])) {
            abort(403, 'Unauthorized. Teacher access required.');
        }
        return $next($request);
    }
}
