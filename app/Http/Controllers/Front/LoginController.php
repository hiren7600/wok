<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Front\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\User;
use App\Models\SeoSetting;

class LoginController extends BaseController
{

    protected $username;

    public function __construct()
    {

        $this->username = $this->findUsername();
    }

    public function findUsername()
    {
        $login = request()->input('login');

        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        request()->merge([$fieldType => $login]);

        return $fieldType;
    }

    public function username()
    {
        return $this->username;
    }

    public function login()
    {
        $data['seosetting'] = SeoSetting::where('page', 'login')->first();
        return view_front('login', $data);
    }

    public function submit(Request $request)
    {

        // if ajax request
        if ($request->ajax()) {

            $rules = [
                'login'    => 'required',
                'password' => 'required',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $errors = $validator->errors()->all();
                $data['type'] = 'error';
                $data['caption'] = 'One or more invalid input found.';
                $data['errorfields'] = $validator->errors()->keys();
            } else {

                $login_type = filter_var($request->input('login'), FILTER_VALIDATE_EMAIL)
                    ? 'email'
                    : 'username';

                // $request->merge([
                //     $login_type => $request->input('login')
                // ]);


                $password = $request->password;
                $remember = 0;
                if ($request->remember) {
                    $remember = 1;
                }

                if(Auth::validate([$login_type => $request->input('login'), 'password' => $password, 'usertype' => 2])){
                    if(Auth::attempt([$login_type => $request->input('login'), 'password' => $password, 'status' => 1], $remember)) {
                        $data['type'] = 'success';
                        $data['redirectUrl'] = url('/feed');
                    }
                    else {
                        $data['type'] = 'error';
                        $data['caption'] = 'Please verify your email address to login.';
                    }
                }
                else {
                    $data['type'] = 'error';
                    $data['caption'] = 'Your member name/Email, or Password is incorrect; please try again!';
                }
            }

            return response()->json($data);
        } else {
            return 'No direct access allowed!';
        }
    }

    public function logout()
    {
        Auth::guard()->logout();
        return redirect('/login');
    }
}
