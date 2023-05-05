<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Front\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use App\Traits\SendgridTrait;
use Illuminate\Support\Facades\Crypt;
use App\Models\User;
use App\Models\Usertoken;
use App\Models\UserMedia;
use App\Models\GroupMember;
use Illuminate\Support\Facades\Storage;
use App\Models\SeoSetting;
use App\Models\otpVerification;
use App\Traits\TwilioApiTrait;


class RegisterController extends BaseController
{

    public function index()
    {

        $data   = [];
        $data['gender']         = config('constants.gender');
        $data['relationships']  = config('constants.relationships');
        $data['orientations']   = config('constants.orientations');
        $data['role']           = config('constants.role');

        $data['seosetting'] = SeoSetting::where('page', 'signup')->first();
        return view_front('signup', $data);
    }

    public function submit(Request $request)
    {
        // if ajax request
        if ($request->ajax()) {
            // dd($request->all());
            $dateofbirth = date("Y-m-d", strtotime($request->dateofbirth));

            $email = trim($request->email);
            $rules = array(
                'username'              => 'required|unique:users',
                'dateofbirth'           => 'required|date|before:-18 years',
                'gender'                => 'required',
                'sexual_orientation'    => 'required',
                'relationship_status'   => 'required',
                'role'                  => 'required',
                'city'                  => 'required',
                'email'                 => 'required|email|unique:users',
                'password'              => 'required|confirmed',
                'password_confirmation' => 'required',
                'phoneno'               => 'required|unique:users',
            );

            $messages = [
                'username.required' => 'Please enter nick name.',
                'username.unique' => 'Nick name is already in use.',
                'dateofbirth.required' => 'Please enter date of birth.',
                'dateofbirth.before' => 'Age should be 18+.',
                'sexual_orientation.required' => 'Please select sexual orientation.',
                'relationship_status.required' => 'Please select relationship status.',
                'gender.required' => 'Please select gender.',
                'role.required' => 'Please select role.',
                'city.required' => 'Please enter city.',
                'email.required' => 'Please enter email address.',
                'email.unique' => 'Email address is already in use.',
                'password.required' => 'Please enter your password.',
                'password_confirmation.required' => 'Please enter your confirm password.',
            ];

            $validator     = Validator::make($request->all(), $rules, $messages);

            // if validation fails
            if ($validator->fails()) {
                $data['type'] = 'error';
                $data['caption'] = 'One or more invalid input found.';
                $data['errorfields'] = $validator->errors()->keys();
                $data['errormessage'] = $validator->errors()->all();
            }
            // if validation success
            else {
                $user = new User();
                $user->username             = $request->username;
                $user->dob                  = $dateofbirth;
                $user->gender               = $request->gender;
                $user->sexual_orientation   = $request->sexual_orientation;
                $user->relationship_status  = $request->relationship_status;
                $user->role                 = $request->role;
                $user->address              = $request->city;
                $user->full_address         = $request->full_address;
                $user->email                = $request->email;
                $user->phoneno              = $request->phoneno;
                $user->password             = Hash::make($request->password);
                $user->usertype             = 2;
                $user->issuperadmin         = 0;
                $user->status               = 1;
                $result = $user->save();

                $captionsuccess = 'User registered successfully.';
                $captionerror = 'Unable register user. Please try again.';

                // database insert/update success
                if ($result) {

                    // $group_ids = [30];

                    // foreach ($group_ids as  $group_id) {
                        $GroupMember = new GroupMember();
                        $GroupMember->group_id = 46;
                        $GroupMember->user_id = $user->user_id;
                        $GroupMember->save();
                    // }

                    $verificationToken = Crypt::encryptString($user->user_id);

                    $usertoken = new Usertoken();
                    $usertoken->user_id = $user->user_id;
                    $usertoken->type = 0;
                    $usertoken->email_username = $user->email;
                    $usertoken->token = $verificationToken;
                    $usertoken->save();

                    // $confirmation_link = url('/user-verification/' . $verificationToken);

                    // $api_response = SendgridTrait::sendEmail([
                    //     //SET SENDGRID EMAIL TEMPLATE ID
                    //     'templateid'  => 'd-fce889fdd76a4607adb9fdedfc01a438',
                    //     //SET SUBJECT FOR WITHOUT USING TEMPLATE
                    //     'subject'    => '',
                    //     //SET BODY FOR WITHOUT USING TEMPLATE
                    //     'body'       => '',
                    //     //SET RECIVER EMAIL AND NAME
                    //     'to'         => [
                    //         // 'to_email'   => $user->email,
                    //         'to_email'   => $user->email,
                    //         'to_name'    => $user->username
                    //     ],
                    //     //SET SENDER EMAIL AND NAME
                    //     'from'      => [
                    //         'from_email' => '',
                    //         'from_name'  => ''
                    //     ],
                    //     //SET DYNAMIC DATA TO REPLACE IN EMAIL TEMPLATE
                    //     'data'      => [
                    //         //SET DYNAMIC TEMPLATE SUBJECT
                    //         'subject'           => 'Verify Your Email',
                    //         'confirmation_link' =>  $confirmation_link,
                    //         'name'              =>  $user->username,
                    //         'support_mail'      =>  config('constants.adminemail')
                    //     ]
                    // ]);

                    // $responseCode = $api_response->statusCode();


                    $data["type"] = "success";


                    // upload image file if exist
                    if ($request->hasFile('imagefile')) {
                        $imagefile   = $request->file('imagefile');
                        $extension = $imagefile->getClientOriginalExtension();

                        $imageName = time() . '.' . $imagefile->getClientOriginalExtension();

                        // //original image
                        // $img = Image::make($imagefile);
                        // $img->fit(config('constants.user_image_width'), null, function ($constraint) {
                        //     $constraint->aspectRatio();
                        // })->encode($extension);

                        // $imagePath = 'users/'.$user->user_id.'/'.$imageName;

                        // $path = Storage::disk('s3')->put($imagePath, (string)$img, 'public');
                        // $amazonImgUrl = Storage::disk('s3')->url($imagePath);

                        // //Thumb image
                        // $imgThumb = Image::make($imagefile);
                        // $imgThumb->fit(config('constants.user_thumb_image_width'), config('constants.user_thumb_image_height'), function ($constraint) {
                        //     $constraint->aspectRatio();
                        // })->encode($extension);

                        // $imagePathThumb = 'users/'.$user->user_id.'/thumb/'.$imageName;

                        // $path = Storage::disk('s3')->put($imagePathThumb, (string)$imgThumb, 'public');
                        // $amazonImgUrlThumb = Storage::disk('s3')->url($imagePathThumb);

                        /******************* Original Image ******************/
                            if ($extension == 'jpeg' || $extension == 'JPEG'  || $extension == 'jpg' || $extension == 'JPG') {
                                $image = imagecreatefromjpeg($imagefile);
                            } elseif ($extension == 'png' || $extension == 'PNG') {
                                $image = imagecreatefrompng($imagefile);
                            }

                            $exif = @exif_read_data($imagefile);
                            if (!empty($exif['Orientation'])) {
                                if ($exif['Orientation'] == 8) {
                                    $image = imagerotate($image, 90, 0);
                                } else if ($exif['Orientation'] == 3) {
                                    $image = imagerotate($image, 180, 0);
                                } else if ($exif['Orientation'] == 6) {
                                    $image = imagerotate($image, -90, 0);
                                }
                            }

                            ob_start();
                            if ($extension == 'jpeg' || $extension == 'JPEG'  || $extension == 'jpg' || $extension == 'JPG') {
                                $imgobject = imagejpeg($image, null, 50);
                            } elseif ($extension == 'png' || $extension == 'PNG') {
                                $bck = imagecolorallocate($image, 0, 0, 0);
                                imagecolortransparent($image, $bck);
                                imagealphablending($image, false);
                                imagesavealpha($image, true);
                                $imgobject = imagepng($image, null, 5);
                            }

                            $image_contents = ob_get_clean();

                            $imagePath = 'users/' . $user->user_id . '/' . $imageName;

                            $path = Storage::disk('s3')->put($imagePath, $image_contents);
                            $amazonImgUrl = Storage::disk('s3')->url($imagePath);
                        /******************* Original Image ******************/

                        /******************* Thumb Image ******************/
                            // if ($extension == 'jpeg' || $extension == 'JPEG'  || $extension == 'jpg' || $extension == 'JPG') {
                            //     $thumbImage = imagecreatefromjpeg($imagefile);
                            // } elseif ($extension == 'png' || $extension == 'PNG') {
                            //     $thumbImage = imagecreatefrompng($imagefile);
                            // }

                            // $exif = @exif_read_data($imagefile);
                            // if (!empty($exif['Orientation'])) {
                            //     if ($exif['Orientation'] == 8) {
                            //         $thumbImage = imagerotate($thumbImage, 90, 0);
                            //     } else if ($exif['Orientation'] == 3) {
                            //         $thumbImage = imagerotate($thumbImage, 180, 0);
                            //     } else if ($exif['Orientation'] == 6) {
                            //         $thumbImage = imagerotate($thumbImage, -90, 0);
                            //     }
                            // }

                            // ob_start();
                            // if ($extension == 'jpeg' || $extension == 'JPEG'  || $extension == 'jpg' || $extension == 'JPG') {
                            //     $thumbImage = imagescale($thumbImage, 100, 100);
                            //     $thumbimgobject = imagejpeg($thumbImage, null, 50);
                            // } elseif ($extension == 'png' || $extension == 'PNG') {
                            //     $thumbImage = imagescale($thumbImage, 100, 100);
                            //     $bck = imagecolorallocate($thumbImage, 0, 0, 0);
                            //     imagecolortransparent($thumbImage, $bck);
                            //     imagealphablending($thumbImage, false);
                            //     imagesavealpha($thumbImage, true);
                            //     $thumbimgobject = imagepng($thumbImage, null, 5);
                            // }

                            // $thumb_image_contents = ob_get_clean();

                            // $imagePathThumb = 'users/' . $user->user_id . '/thumb/' . $imageName;

                            // $path = Storage::disk('s3')->put($imagePathThumb, $thumb_image_contents);
                            // $amazonImgUrlThumb = Storage::disk('s3')->url($imagePathThumb);
                        /******************* Thumb Image ******************/

                        /******************* Thumb Image ******************/
                            //Thumb small image
                            $imgThumbsmall = Image::make($image_contents);
                            $imgThumbsmall->fit(config('constants.user_small_thumb_image_width'), config('constants.user_small_thumb_image_height'), function ($constraint) {
                                $constraint->aspectRatio();
                            })->encode($extension);

                            $imageSmallPathThumb = 'users/'.$user->user_id.'/thumb/small/'.$imageName;

                            $smallThumbPath = Storage::disk('s3')->put($imageSmallPathThumb, $imgThumbsmall);
                            $amazonImgUrlSmallThumb = Storage::disk('s3')->url($imageSmallPathThumb);


                            //Thumb medium image
                            $imgThumbmedium = Image::make($image_contents);
                            $imgThumbmedium->fit(config('constants.user_medium_thumb_image_width'), config('constants.user_medium_thumb_image_height'), function ($constraint) {
                                $constraint->aspectRatio();
                            })->encode($extension);

                            $imageMediumPathThumb = 'users/'.$user->user_id.'/thumb/medium/'.$imageName;

                            $mediumThumbPath = Storage::disk('s3')->put($imageMediumPathThumb, $imgThumbmedium);
                            $amazonImgUrlMediumThumb = Storage::disk('s3')->url($imageMediumPathThumb);


                            //Thumb large image
                            $imgThumblarge = Image::make($image_contents);
                            $imgThumblarge->fit(config('constants.user_large_thumb_image_width'), config('constants.user_large_thumb_image_height'), function ($constraint) {
                                $constraint->aspectRatio();
                            })->encode($extension);

                            $imageLargePathThumb = 'users/'.$user->user_id.'/thumb/large/'.$imageName;

                            $largeThumbPath = Storage::disk('s3')->put($imageLargePathThumb, $imgThumblarge);
                            $amazonImgUrlLargeThumb = Storage::disk('s3')->url($imageLargePathThumb);
                        /******************* Thumb Image ******************/

                        $user->imagefile = $amazonImgUrl;
                        $user->smallthumbfile = $amazonImgUrlSmallThumb;
                        $user->mediumthumbfile = $amazonImgUrlMediumThumb;
                        $user->largethumbfile = $amazonImgUrlLargeThumb;
                        $user->update();

                        $user_media = new UserMedia();
                        $user_media->user_id            = $user->user_id;
                        $user_media->mediafile          = $amazonImgUrl;
                        $user_media->smallthumbfile     = $amazonImgUrlSmallThumb;
                        $user_media->mediumthumbfile    = $amazonImgUrlMediumThumb;
                        $user_media->largethumbfile     = $amazonImgUrlLargeThumb;
                        $user_media->mediatype          = 1;
                        $user_media->save();

                        $data["type"] = "success";
                    }
                    // if no image uploaded
                    else {
                        $data["type"] = "success";
                    }


                    if ($data["type"] == 'success') {
                        $data['caption'] = $captionsuccess;
                        $data['redirectUrl'] = url('/');
                        $data['user_id'] = $user->user_id;
                        $data['user_email'] = $user->email;
                    }
                }
                // database insert/update fail
                else {
                    $data['type'] = 'error';
                    $data['caption'] = $captionerror;
                }
            }
            return response()->json($data);
        } else {
            return 'No direct access allowed!';
        }
    }


    public function resendverification(Request $request)
    {
        // if ajax request
        if ($request->ajax()) {
            $user_id = intval($request->user_id);

            $user = User::find($user_id);

            if ($user) {
                $usertoken = Usertoken::where('user_id', $user->user_id)->where('type', 0)->first();
                if ($usertoken) {
                    $confirmation_link = url('/user-verification/' . $usertoken->token);
                } else {
                    $verificationToken = Crypt::encryptString($user->user_id);

                    $usertokennew = new Usertoken();
                    $usertokennew->user_id          = $user->user_id;
                    $usertokennew->type             = 0;
                    $usertokennew->email_username   = $user->email;
                    $usertokennew->token            = $verificationToken;
                    $usertokennew->save();

                    $confirmation_link = url('/user-verification/' . $verificationToken);
                }

                $api_response = SendgridTrait::sendEmail([
                    //SET SENDGRID EMAIL TEMPLATE ID
                    'templateid'  => 'd-fce889fdd76a4607adb9fdedfc01a438',
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
                        'subject'           => 'Verify Your Email',
                        'confirmation_link' =>  $confirmation_link,
                        'name'              =>  $user->username,
                        'support_mail'      =>  config('constants.adminemail')
                    ]
                ]);

                $responseCode = $api_response->statusCode();


                $data["type"] = "success";
                $data['caption'] = 'Verification email sent successfully.';
            }
            // database insert/update fail
            else {
                $data['type'] = 'error';
                $data['caption'] = 'Unable to send verification email.';
            }

            return response()->json($data);
        } else {
            return 'No direct access allowed!';
        }
    }

    public function sendverificationcode(Request $request)
    {
        // dd($request);
        // if ajax request
        if ($request->ajax()) {
            $phoneno = trim($request->phoneno);
            $email = trim($request->email);

            $verifyOTP = rand(1000,9999);
            // dd($verifyOTP);
            $msg = "Your WOK registration code $verifyOTP";
            //SEND SMS USING TWILIO API
            $api_response = TwilioApiTrait::callApi([
                'method'    => 'post',
                'headers'   => [
                    'Content-Type: application/json'
                ],
                'data' => [
                    // 'Body' => 'Your verification code is for signup is '.$verifyOTP.'.',
                    'Body' => $msg,
                    'To'   => $phoneno
                ]
            ]);
            $response = json_decode($api_response, TRUE);

            if($response['status'] != 400) {
                $otpverification = new otpVerification();
                $otpverification->phoneno = $phoneno;
                $otpverification->email = $email;
                $otpverification->otp = $verifyOTP;
                $result = $otpverification->save();
                $data['type'] = 'success';
                $data['caption'] = 'Otp sent successfully.';
            }
            else {
                $data['type'] = 'error';
                $data['caption'] = 'Unable to send otp to your phone number.';
            }


            return response()->json($data);
        } else {
            return 'No direct access allowed!';
        }
    }

    public function completeverificationcode(Request $request)
    {
        // if ajax request
        if ($request->ajax()) {
            $phoneno = trim($request->phoneno);
            $email = trim($request->email);
            $otp = trim($request->otp);

            $otpverification = otpVerification::where('email', $email)->where('otp', $otp)->first();

            if(!empty($otpverification)) {
                $otpverification->isverified = 1;
                $otpverification->update();
                $data['type'] = 'success';
                $data['caption'] = 'Otp verified successfully.';
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


    public function username(Request $request)
    {
        // if ajax request
        if ($request->ajax()) {
            $username = trim($request->username);
            $user = User::where('username', $username)->first();
            if ($user) {
                return 'false';
            } else {
                return 'true';
            }
        } else {
            return 'No direct access allowed!';
        }
    }

    public function email(Request $request)
    {
        // if ajax request
        if ($request->ajax()) {
            $email = trim($request->email);
            $user = User::where('email', $email)->first();

            if ($user) {
                return 'false';
            } else {
                return 'true';
            }
        } else {
            return 'No direct access allowed!';
        }
    }

    public function phoneno(Request $request)
    {
        // if ajax request
        if ($request->ajax()) {
            $phoneno = trim($request->phoneno);
            $user = User::where('phoneno', $phoneno)->first();
            $data['type'] = 'error';
            if (empty($user)) {
                $data['type'] = 'success';
            }

            return response()->json($data);
        } else {
            return 'No direct access allowed!';
        }
    }

    public function phonenovoip(Request $request)
    {
        // if ajax request
        if ($request->ajax()) {
            $phoneno = trim($request->phoneno);
            
            $api_response = TwilioApiTrait::LookupApi($phoneno);
            $response = json_decode($api_response, TRUE);

            $data['type'] = 'error';
            if($response['line_type_intelligence']['type'] == 'mobile') {
                $data['type'] = 'success';
            }
            

            return response()->json($data);
        } else {
            return 'No direct access allowed!';
        }
    }

    public function verification($token)
    {
        $data   = [];
        if (!empty(trim($token))) {
            $usertoken = Usertoken::where('token', $token)->where('type', 0)->first();

            if (!empty($usertoken)) {
                $user = User::find($usertoken->user_id);
                if (!empty($user)) {
                    if ($user->status == 0) {
                        $user->status = 1;
                        $user->update();
                        // $usertoken->delete();
                        $data['status'] = "verified";
                    } else {
                        $data['status'] = "already_verified";
                    }

                    return view_front('user_verification', $data);
                } else {
                    return abort('404');
                }
            } else {
                return abort('404');
            }
        } else {
            return abort('404');
        }
    }
}
