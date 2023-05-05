<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Front\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use App\Traits\SendgridTrait;
use App\Models\User;
use App\Models\Usertoken;
use Carbon\Carbon;
use App\Models\SeoSetting;

class ResetPasswordController extends BaseController
{
    public function forgotpassword()
    {
        $data['seosetting'] = SeoSetting::where('page', 'forgot-password')->first();
        return view_front('forgotpassword', $data);
    }

    public function forgotsubmit(Request $request) {
        // dd($request);
        if ($request->ajax()) {

            $username             = trim($request->username);
            $rules = array(
                'username'            => 'required',
            );

            $validator = Validator::make($request->all(), $rules);

            $validator->after(function ($validator) use ($username) {
                // check provided email availability
                $res = User::where('email', $username)->orWhere('username', $username)->get();

                if (count($res) == 0) {
                    $validator->errors()->add('email', 'No such email or member name found, please verify the email or member name entered.');
                }
            });

            // validation fails
            if ($validator->fails()) {
                $data['caption'] = $validator->errors()->first();
            } else {

                $data = [];

                $user = User::where('email', $username)->orWhere('username', $username)->first();
                $userid = $user->user_id;
                $token = Crypt::encryptString($userid);

                $usertoken = Usertoken::where('user_id', $userid)->where('type', 1)->first();
                
                if(!empty($usertoken)) {
                    $usertoken->delete();    
                }

                $usertoken_new                  = new Usertoken();
                $usertoken_new->user_id         = $userid;
                $usertoken_new->type            = 1;
                $usertoken_new->email_username  = $request->username;
                $usertoken_new->token           = $token;   
                $result = $usertoken_new->save() ;
                

                if ($result) {

                    $reset_password_link = url('/reset-password/'.$token);

                    $api_response = SendgridTrait::sendEmail([
                        //SET SENDGRID EMAIL TEMPLATE ID
                        'templateid'  => 'd-93d0620c0d0d423c9ad34024f2b8df52',
                        //SET SUBJECT FOR WITHOUT USING TEMPLATE
                        'subject'    => '',
                        //SET BODY FOR WITHOUT USING TEMPLATE
                        'body'       => '',
                        //SET RECIVER EMAIL AND NAME
                        'to'         => [
                            // 'to_email'   => $user->email,
                            'to_email'   => $user->email,
                            'to_name'    => $user->username
                        ],
                        //SET SENDER EMAIL AND NAME
                        'from'      => [
                            'from_email' => '',
                            'from_name'  => ''
                        ],
                        //SET DYNAMIC DATA TO REPLACE IN EMAIL TEMPLATE
                        'data'      => [
                            //SET DYNAMIC TEMPLATE SUBJECT
                            'subject'               => 'Reset Password',
                            'reset_password_link'   =>  $reset_password_link,
                            'name'                  =>  $user->username,
                            'support_mail'          =>  config('constants.adminemail')
                        ]
                    ]);
                    
                    $responseCode = $api_response->statusCode();
                                        
                    $data['type'] = 'success';
                    $data['caption'] = 'Reset password link sent to your email address.';
                } else {
                    $data['type'] = 'error';
                    $data['caption'] = 'Unable to process your request. Please try again.';
                }
            }
            return response()->json($data);
        } else {
            return "No direct access allowed";
        }
    }

    public function resetpassword($token)
    {
        $data = [];
        $usertoken = Usertoken::where('token', $token)->where('type', 1)->first();

        if($usertoken) {
            $created_at = Carbon::parse($usertoken->created_at);
            $current_time = Carbon::now();
            $totalDuration = $current_time->diffInMinutes($created_at);
            $verification_time = config('constants.verification_time');
            $data['seosetting'] = SeoSetting::where('page', 'reset-password')->first();
            
            if($totalDuration <= $verification_time) {
                $data['status'] = 'success';
                $data['usertoken'] = $usertoken;
                return view_front('resetpassword', $data);    
            }
            else {
                $data['status'] = 'expired';
                return view_front('resetpassword', $data);
            }
        }
        else {
            abort('404');
        }
        
    }

    public function resetsubmit(Request $request)
    {
        if ($request->ajax()) {
            $request->validate([
                // 'email' => 'required|email|exists:users',
                'password' => 'required|confirmed',
                'password_confirmation' => 'required'
            ]);

            $usertoken = Usertoken::where('token', $request->token)->where('type', 1)->first();
            
            if ($usertoken) {
                $user = User::find($usertoken->user_id);
                if(!Hash::check($request->password, $user->password)){
                    $user->password = Hash::make($request->password);
                    $user->update();

                    $usertoken->delete();

                    $data['type'] = 'success';
                    $data['caption'] = 'Password reset successfully.';
                    $data['redirectUrl'] = url('/login');    
                }
                else {
                    $data['type'] = 'error';
                    $data['caption'] = 'You can not use your current password as a new password.';
                }
            }   
            else {
                $data['type'] = 'error';
                $data['caption'] = 'Invalid token. Please try again!';
            }


            return response()->json($data);
        } else {
            return "No direct access allowed";
        }
    }
}
