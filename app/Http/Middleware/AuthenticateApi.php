<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;
use App\Models\User;

class AuthenticateApi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        $user = User::where(['user_session_token' => $request->header('token')])->first();
		
        if($user)
        {
			$request->attributes->set('user_id', $user->id);
			$request->attributes->set('device_token', $user->device_token);
			return $next($request);
        }
        else
        {
			return response()->json(['Login Expired'], 401);
        }
    }
}
