<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckEmployeeRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        $roles = array_slice(func_get_args(),2);

        foreach ($roles as $rol) {

            if(auth()->user()->hasEmployeeRole($rol)){
                return $next($request);
            }
        }

        return response()->json([
            'res' => false,
            'message' => 'No tiene permisos para esta función'
        ],401);
    }
}
