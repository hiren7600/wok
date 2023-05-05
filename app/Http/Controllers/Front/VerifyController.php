<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Front\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\SeoSetting;
use App\Models\User;
use App\Models\otpVerification;

class VerifyController extends BaseController {
    
    public function index() {
        $data = [];
        $user = $this->globaldata['user'];
        $data['user'] = $user;

        return view_front('verify-phone',$data);
    }

    public function submit(Request $request) {
        if ($request->ajax()) {
            // dd($request->all());
            

            $user = $this->globaldata['user'];
            
            $phoneno = trim($request->phoneno);
            $email = trim($request->email);
            $otp1 = trim($request->otp1);
            $otp2 = trim($request->otp2);
            $otp3 = trim($request->otp3);
            $otp4 = trim($request->otp4);

            $otp = $otp1.$otp2.$otp3.$otp4;


            $otpverification = otpVerification::where('email', $email)->where('otp', $otp)->first();

            if(!empty($otpverification)) {
                $otpverification->isverified = 1;
                $otpverification->update();
                $user->phoneno = $phoneno;
                $user->update();
                $data['type'] = 'success';
                $data['caption'] = 'Otp verified successfully.';
                $data['redirectUrl'] = url('/feed');
            }
            else {
                $data['type'] = 'error';
                $data['caption'] = 'Unable to verify otp.';
            }
       

            return response()->json($data);
        } else {
            return 'No direct access allowed!';
        }
    }
}
