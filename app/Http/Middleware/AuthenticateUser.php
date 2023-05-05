<?php namespace App\Http\Middleware;
use Auth;
use Closure;
use Illuminate\Http\Response as Res;
use Illuminate\Http\RedirectResponse;

class AuthenticateUser {

	protected $auth;

	public function __construct() {

		// $this->auth = Auth::guard('user');
		$this->auth = Auth::guard();

	}

	public function handle($request, Closure $next)	{

		if ($this->auth->guest()) {
			// AJAX REQUEST
			if($request->ajax()) {
				$data = [];
				$data['type'] = 'error';
				$data['caption'] = getTranslation('Unauthorized access.');
				$data['redirectUrl'] = url('/login');
				return response()->json($data);

			}
			// NON AJAX REQUEST
			else {
				return redirect()->guest('/login');
			}
		}
		elseif($this->auth->user()->phoneno == "" && $request->path() != 'verify-phone' && $request->path() != 'logout') {
			return redirect(url('/verify-phone'));
		}
		elseif($this->auth->user()->phoneno != "" && $request->path() == 'verify-phone') {
			return redirect(url('/feed'));
		}

		return $next($request);
	}

}