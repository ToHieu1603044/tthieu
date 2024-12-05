<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
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
        if (Auth::check()) {
            $user = Auth::user();
           if($user->id==3||$user->id==4){
            if ($user->hasRole(['admin', 'subadmin'])) {
                return $next($request); 
            }
           }
            abort(403); 
        }
        abort(401); 
    }
}
