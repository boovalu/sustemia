<?php
/*
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, ...$roles)
    {
        // dd($request->all());
        // Verificar si el usuario está autenticado y si tiene uno de los roles necesarios
        if (!Auth::check() || !in_array(Auth::user()->role->name, $roles)) {
            // Si no tiene acceso, redirigir a la página de inicio con un mensaje de advertencia
            return redirect('/')->with('warning', 'No tiene permisos para acceder a esta sección.');
        }

        // Si tiene acceso, permitir que el request continúe
        return $next($request);
    }
}
*/

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class RoleMiddleware
{
    public function handle($request, Closure $next, ...$roles)
    {
        // Verificar si el usuario está autenticado
        if (!Auth::check()) {
            return redirect('/')->with('warning', 'No has iniciado sesión.');
        }

        // Verificar si el rol del usuario está permitido
        if (!in_array(Auth::user()->role->name, $roles)) {
            // Log para depuración
          //  Log::info('Usuario sin permisos', ['user' => Auth::user()]);
       //     return redirect('/')->with('warning', 'No tiene permisos para acceder a esta sección.');
        }

        return $next($request);
    }
}