<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string[]  ...$roles
     * @return mixed
     */
    public function handle($request, Closure $next, ...$roles)
    {
        // 1. Debe estar autenticado
        if (!Auth::check()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'No autenticado.'], 401);
            }
            return redirect()->guest('login');
        }

        $user = Auth::user();

        // 2. Comprobar que la cuenta esté activa
        if (!$user->isActivo()) {
            Auth::logout();
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Tu cuenta ha sido desactivada.'], 403);
            }
            return redirect('login')->withErrors(['email' => 'Tu cuenta de usuario se encuentra inactiva. Contacta al administrador.']);
        }

        // 3. El Administrador siempre tiene acceso irrestricto a todo
        if ($user->isAdmin()) {
            return $next($request);
        }

        // 4. Aplanar lista de roles permitidos (acepta parámetros múltiples o separados por coma)
        $allowedRoles = [];
        foreach ($roles as $roleGroup) {
            foreach (explode(',', $roleGroup) as $r) {
                $trimmed = strtolower(trim($r));
                if (!empty($trimmed)) {
                    $allowedRoles[] = $trimmed;
                }
            }
        }

        // 5. Validar si el usuario cumple con alguno de los roles permitidos
        $hasAccess = false;
        foreach ($allowedRoles as $role) {
            if ($role === 'admin' && $user->isAdmin()) {
                $hasAccess = true;
                break;
            }
            if (($role === 'vendedor' || $role === 'v1') && $user->isVendedor()) {
                $hasAccess = true;
                break;
            }
            if (($role === 'taller' || $role === 't1') && $user->isTaller()) {
                $hasAccess = true;
                break;
            }
            if (strtolower($user->tipo_usuario) === $role) {
                $hasAccess = true;
                break;
            }
        }

        // 6. Si no tiene acceso, bloquear y redirigir
        if (!$hasAccess) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No tienes permisos para acceder a esta sección o función.'
                ], 403);
            }

            // Redirección amigable a la pantalla principal del rol
            if ($user->isTaller()) {
                return redirect('sb-admin/ordenes-taller')->with('error_permiso', 'No tienes permisos para acceder a ese módulo.');
            }

            return redirect('sb-admin/dashboard')->with('error_permiso', 'No tienes permisos para acceder a ese módulo.');
        }

        return $next($request);
    }
}
