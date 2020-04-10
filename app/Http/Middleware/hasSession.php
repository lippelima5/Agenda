<?php

namespace App\Http\Middleware;

use App\Colaboradores;
use Closure;

class hasSession
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
        $acess_key = $request->session()->get('acess_key');
        
        if (!isset($acess_key)) {
            return redirect('/');
        }

        $colaborador = Colaboradores::where('c_key', '=', $acess_key)->first();

        if ($colaborador->c_key != $acess_key) {

            return redirect('/'); //login page
        }




        return $next($request);
    }
}
