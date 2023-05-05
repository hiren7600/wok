<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Front\BaseController;
use App\Models\NotificationSetting;
use Illuminate\Http\Request;
use App\Models\UserMediaLike;
use App\Models\UserMedia;
use App\Models\SeoSetting;
use App\Models\User;
use App\Traits\SendgridTrait;

class MediaController extends BaseController {

    public function medialike(Request $request) {
        if ($request->ajax()) {

            $user= $this->globaldata['user'];
            $media_id = $request->media_id;

            $user_media = UserMediaLike::where('media_id', '=', $media_id)->where('user_id',$user->user_id)->first();

            if ($user_media) {
                $result = UserMediaLike::where('media_id', '=', $media_id)->where('user_id',$user->user_id)->delete();
            }
            else {
                $user_media_like = new UserMediaLike();
                $user_media_like->media_id = $media_id;
                $user_media_like->user_id = $user->user_id;
                $result = $user_media_like->save();

                $user_media_like = UserMedia::where('media_id', '=', $media_id)->first();

                if ($user->user_id != $user_media_like->user_id) {

                    $from_user = User::where('user_id', $user_media_like->user_id)->first();
                    $user_profile = url('/profile/'.$user->user_id);
                    $notification_setting = NotificationSetting::where('user_id', $user_media_like->user_id)->first();

                    if ($user_media_like->mediatype == 2) {

                        $current_url = url('/video-detail/'.$media_id);
                        userNotification($user->user_id,$user_media_like->user_id, 'videolike' ,$current_url,$user_media_like->videothumbfile,'');

                        $subject = $user->username.' liked your video.';


                        if ($notification_setting->like_video == 1) {
                            if(!empty($from_user)) {
                                $api_response = SendgridTrait::sendEmail([
                                    //SET SENDGRID EMAIL TEMPLATE ID
                                    'templateid'  => 'd-9eb14e5488a8447dafda31b68362406c',
                                    //SET SUBJECT FOR WITHOUT USING TEMPLATE
                                    'subject'    => '',
                                    //SET BODY FOR WITHOUT USING TEMPLATE
                                    'body'       => '',
                                    //SET RECIVER EMAIL AND NAME
                                    'to'         => [
                                        // 'to_email'   => $user->email,
                                        'to_email'   => $from_user->email,
                                        'to_name'    => $from_user->username
                                    ],
                                    //SET SENDER EMAIL AND NAME
                                    'from'      => [
                                        'from_email' =>'',
                                        'from_name'  =>''
                                    ],
                                    //SET DYNAMIC DATA TO REPLACE IN EMAIL TEMPLATE
                                    'data'      => [
                                        //SET DYNAMIC TEMPLATE SUBJECT
                                        'subject'           =>  $subject,
                                        'current_url'       =>  $current_url,
                                        'name'              =>  $from_user->username,
                                        'from_user'         =>  $user->username,
                                        'from_user_profile' =>  $user_profile,
                                        'support_mail'      =>  config('constants.adminemail')
                                    ]
                                ]);
                            }
                        }
                    }

                    if ($user_media_like->mediatype == 1) {

                        $current_url = url('/image-detail/'.$media_id);
                        userNotification($user->user_id,$user_media_like->user_id, 'imagelike' ,$current_url,$user_media_like->smallthumbfile,'');

                        $subject = $user->username.' liked your image.';
                        if ($notification_setting->like_image == 1) {
                            if(!empty($from_user)) {
                                $api_response = SendgridTrait::sendEmail([
                                    //SET SENDGRID EMAIL TEMPLATE ID
                                    'templateid'  => 'd-05058c9beb6f4c01b6d4ff06e9050b66',
                                    //SET SUBJECT FOR WITHOUT USING TEMPLATE
                                    'subject'    => '',
                                    //SET BODY FOR WITHOUT USING TEMPLATE
                                    'body'       => '',
                                    //SET RECIVER EMAIL AND NAME
                                    'to'         => [
                                        // 'to_email'   => $user->email,
                                        'to_email'   => $from_user->email,
                                        'to_name'    => $from_user->username
                                    ],
                                    //SET SENDER EMAIL AND NAME
                                    'from'      => [
                                        'from_email' =>'',
                                        'from_name'  =>''
                                    ],
                                    //SET DYNAMIC DATA TO REPLACE IN EMAIL TEMPLATE
                                    'data'      => [
                                        //SET DYNAMIC TEMPLATE SUBJECT
                                        'subject'           =>  $subject,
                                        'current_url'       =>  $current_url,
                                        'name'              =>  $from_user->username,
                                        'from_user'         =>  $user->username,
                                        'from_user_profile' =>  $user_profile,
                                        'support_mail'      =>  config('constants.adminemail')
                                    ]
                                ]);
                            }
                        }
                    }
                }
            }

            if($result){
                $mediacounts = UserMediaLike::where('media_id', '=', $media_id)->get()->count();
                $data["type"] = "success";
                $data["mediacounts"] = $mediacounts;
                // $data["media_id"] = $media_id;
            } else {
                $data["type"] = "error";
                $data["caption"] = "Unable to like. Please try again later.";
            }

            return response()->json($data);
        } else {
            return 'No direct access allowed!';
        }
    }

    public function video() {
        $usermedias = UserMedia::where('is_exposed', 1)->where('mediatype', 2)->with('comments')->with('videocomments')->with('user')->latest()->get();
        $data['usermedias'] = $usermedias;
        $data['user'] = $this->globaldata['user'];
        $data['seosetting'] = SeoSetting::where('page', 'videos')->first();
        return view_front('videos', $data);
    }

    public function allvideos() {
        $usermedias = UserMedia::where('mediatype', 2)->with('comments')->with('videocomments')->with('user')->latest()->get()->take(config('constants.perpage'));
        $data['usermedias'] = $usermedias;
        $data['user'] = $this->globaldata['user'];
        $data['seosetting'] = SeoSetting::where('page', 'videos')->first();
        return view_front('videos', $data);
    }

    public function videosload(Request $request) {
        // if ajax request
        if ($request->ajax()) {

            $data   = [];
            $user = $this->globaldata['user'];

            $usermedias = UserMedia::where('mediatype', 2)->with('comments')->with('videocomments')->with('user')->latest();

            $itemcount = $usermedias->get()->count();
            $data['usermedias'] = $usermedias->paginate(config('constants.perpage'));

            $data['user'] = $user;


            $htmldata = view_front('ajax.videos', $data)->render();

            return response()->json(['htmldata' => $htmldata, 'itemcount' => $itemcount]);
        }
        // if non ajax request
        else {
            return 'No direct access allowed!';
        }
    }

    public function image(){
        if ($this->globaldata['user']->issuperadmin == 1  ) {
            $usermedias = UserMedia::where('mediatype', 1)->latest()->get()->take(config('constants.perpage'));
            $data['usermedias'] = $usermedias;
            $data['user'] = $this->globaldata['user'];
            return view_front('images', $data);
        }else{
            return abort('404');
        }

    }

    public function loadimage(Request $request) {
        // if ajax request
        if ($request->ajax()) {

            $data   = [];
            $user = $this->globaldata['user'];

            $usermedias = UserMedia::where('mediatype', 1)->latest();

            $iamgecount = $usermedias->get()->count();
            $data['usermedias'] = $usermedias->paginate(config('constants.perpage'));


            $htmldata = view_front('ajax.images', $data)->render();

            return response()->json(['htmldata' => $htmldata, 'iamgecount' => $iamgecount]);
        }
        // if non ajax request
        else {
            return 'No direct access allowed!';
        }
    }
}
