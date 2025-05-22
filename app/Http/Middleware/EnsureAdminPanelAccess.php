<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdminPanelAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if ($user && in_array($user->role, ['admin', 'user', 'dp_head'])) {
            return $next($request);
        }

        abort(403, 'Unauthorized access to admin panel.');
    }
}
