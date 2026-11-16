<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsurePermission
{
    public function handle(
        Request $request,
        Closure $next,
        string $permission
    ): Response {
        $user = $request->user();

        if (!$user || !$user->role) {
            abort(403, 'Anda tidak memiliki akses.');
        }

        $hasPermission = $user->role
            ->permissions()
            ->where('name', $permission)
            ->exists();

        if (!$hasPermission) {
            abort(403, 'Anda tidak memiliki hak akses untuk fitur ini.');
        }

        return $next($request);
    }
}
