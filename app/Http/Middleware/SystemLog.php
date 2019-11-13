<?php

namespace App\Http\Middleware;

use App\Models\Cms\SystemLogs;

class SystemLog
{

	public function handle($request, \Closure $next)
	{

		$response = $next($request);

		// Perform action

		if($request->method() != 'GET') {
			$user = auth()->user();
			$action = $request->path();

			$data = $request->all();
			SystemLogs::add($user, $action, $data);
		}
		//


		return $response;
	}
}
