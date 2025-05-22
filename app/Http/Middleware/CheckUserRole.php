<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user();
        $rol = \App\Models\Rol::find($user->rol_id);
        //echo "rol: " . $rol->name;
        if ($user && in_array($rol->name, $roles)) {
            return $next($request);
        }

        abort(403, 'No tienes permiso para acceder a esta ruta.');
    }
}
