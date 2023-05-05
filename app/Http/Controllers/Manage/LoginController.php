<?php namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;


class LoginController extends Controller
{

    public function __construct() {
		// $this->middleware('adminguest');
	}

	public function login() {
        
		return view_admin('login');
	}

	public function submit(Request $request) {

		// if ajax request
		if($request->ajax()) {

			$rules = [
					'email'   => 'required|email',
					'password'   => 'required'
			];

			$validator = Validator::make($request->all(), $rules);

			if($validator->fails()) {

				$errors = $validator->errors()->all();
				$data['type'] = 'error';
				$data['caption'] = 'One or more invalid input found.';
				$data['errorfields'] = $validator->errors()->keys();

			}
			else {

				$email = trim($request->email);
				$password = $request->password;
				$remember = 0;
				if($request->remember){
					$remember = 1;
				}

				if(Auth::guard('admin')->attempt(['email' => $email,'password' => $password, 'status' => 1, 'usertype' => 1], $remember)) {

					$data['type'] = 'success';
					$data['redirectUrl'] = url_admin('dashboard');
				}
				elseif(Auth::guard('member')->attempt(['email' => $email,'password' => $password, 'status' => 1, 'usertype' => 2], $remember)) {

					$data['type'] = 'success';
					$data['redirectUrl'] = url_admin('projects');
				}
				elseif(Auth::guard('client')->attempt(['email' => $email,'password' => $password, 'status' => 1, 'usertype' => 3], $remember)) {

					$data['type'] = 'success';
					$data['redirectUrl'] = url_admin('projects');
				}
				else {
					$data['type'] = 'error';
					$data['caption'] = 'Invalid email address or password.';
				}

			}

			return response()->json($data);
		}
		else{
			return 'No direct access allowed!';
		}
	}

}
