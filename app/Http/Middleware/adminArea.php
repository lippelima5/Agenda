<?php

namespace App\Http\Middleware;

use Closure;

class adminArea
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
        $tipo = $request->session()->get('tipo');

        if ($tipo === 1 || $tipo === 2) {
            return response()->json([
                'message' => "Você não tem autorização para acessar essa página",
            ], 401);
        }

        return $next($request);
    }
}
