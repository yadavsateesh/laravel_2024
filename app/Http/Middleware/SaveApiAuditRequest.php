<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Closure;
use App\Models\Api_audit;
use App\Models\User;

class SaveApiAuditRequest
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
        return $next($request);
    }
	
	public function terminate($request, $response)
    {
		$api_audit = new Api_audit();
		$api_audit->user_type = 'user';
		
		if($request->header('token'))
        {
			$user = User::where('remember_token', $request->header('token'))->first();
			$api_audit->user_id = $user ? $user->id : NULL;
		}
		
		$api_audit->api_name = Request::path();
		$api_audit->request_json = json_encode($request->all());
		$api_audit->response_json = $response->getContent();
		$api_audit->created_at = date("Y-m-d H:i:s");
		$api_audit->time_taken = round(microtime(true) * 1000);
		$api_audit->save();
    }
}
