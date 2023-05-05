<?php namespace App\Http\Middleware;
use Auth;
use Closure;
use Illuminate\Http\Response as Res;

class AuthenticateAdmin {

	protected $auth;

	public function __construct() {
		// $this->auth = Auth::guard('admin');
		$this->auth = Auth::guard();
	}

	public function handle($request, Closure $next)	{
		if ($this->auth->guest()) {
			// AJAX REQUEST
			if($request->ajax()) {
				$data = [];
				$data['type'] = 'error';
				$data['caption'] = 'Unauthorized access.';
				$data['redirectUrl'] = url('/manage/login');
				return response()->json($data);
			}
			// NON AJAX REQUEST
			else {
				return redirect()->guest('/manage/login');
			}

		}
		return $next($request);
	}

}