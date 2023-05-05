<?php namespace App\Http\Middleware;
use Auth;
use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\RedirectResponse;

class RedirectIfAuthenticatedAdmin {

	protected $auth;

	public function __construct() {
		// $this->auth = Auth::guard('admin');
		$this->auth = Auth::guard();
	}

	public function handle($request, Closure $next)	{
		if ($this->auth->check()) {
			if($request->ajax()) {
				$data = [];
				$data['type'] = 'success';
				$data['redirectUrl'] = url('/manage/dashboard');
				return response()->json($data);
			}
			else {
				return new RedirectResponse(url('/manage/dashboard'));
			}
		}
		return $next($request);
	}

}