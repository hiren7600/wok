<?php namespace App\Http\Middleware;
use Auth;
use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\RedirectResponse;

class RedirectIfAuthenticatedUser {

	protected $auth;

	public function __construct() {
		// $this->auth = Auth::guard('user');
		$this->auth = Auth::guard();
	}

	public function handle($request, Closure $next)	{
		if ($this->auth->check()) {
			if($request->ajax()) {
				$data 					= [];
				$data['type'] = 'success';
				$data['redirectUrl'] = url('/feed');
				return response()->json($data);
			}
			else {
				return new RedirectResponse(url('/feed'));
			}
		}
		
		return $next($request);
	}

}