<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Front\BaseController;
use Illuminate\Http\Request;

use App\Models\Friend;
use App\Models\User;
use App\Models\SeoSetting;
use App\Traits\SendgridTrait;

class FriendController extends BaseController {

    public function index() {
        $data   = [];
        $user = $this->globaldata['user'];

        $friends = Friend::where('to_user_id', $user->user_id)->where('status', 0)->latest()->get();
        $data['friends'] = $friends;

        $friendslist = Friend::where('status', 1)
        ->where('to_user_id', $user->user_id)
        ->orwhere(function($query) use($user) {
            $query->where('user_id', $user->user_id)->where('status', 1);
        })->latest()->get();
        $data['friendslist'] = $friendslist;

        $data['seosetting'] = SeoSetting::where('page', 'friend-request')->first();

        return view_front('friend-request', $data);
    }

    public function submit(Request $request) {
        // dd($request);
        if ($request->ajax()) {

            $to_user_id = $request->to_user_id;
            $comment = $request->comment;

            $user = $this->globaldata['user'];
            $user_id = $user->user_id;

            $friend = new Friend();
            $friend->user_id    = $user_id;
            $friend->to_user_id = $to_user_id;
            $friend->comment    = $comment;
            $result = $friend->save();


            $from_user = User::where('user_id', $to_user_id)->first();
            if(!empty($from_user)) {
                $api_response = SendgridTrait::sendEmail([
                    //SET SENDGRID EMAIL TEMPLATE ID
                    'templateid'  => 'd-04864fecdc8d4f6b92547010f13b8dbc',
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
                        'subject'           => $user->username.' sent you a friend request',
                        'confirmation_link' => '',
                        'name'              =>  $from_user->username,
                        'from_user'         =>  $user->username,
                        'support_mail'      =>  config('constants.adminemail')
                    ]
                ]);
            }


            if($result) {
                $data['type'] = 'success';
                $data['caption'] = 'Friend request sent!';
            }
            else {
                $data['type'] = 'error';
                $data['caption'] = 'Unable to send friend request. Please try again later.';
            }

            return response()->json($data);
        } else {
            return 'No direct access allowed!';
        }
    }

    public function friendrequestcancel(Request $request) {

        if ($request->ajax()) {

            $to_user_id = $request->to_user_id;
            $comment = $request->comment;

            $user = $this->globaldata['user'];
            $user_id = $user->user_id;

            $friend = Friend::where('user_id', $user_id)->where('to_user_id', $to_user_id)->first();
            $result = $friend->delete();

            if($result) {
                $data['type'] = 'success';
                $data['caption'] = 'Friend request cancelled!';
            }
            else {
                $data['type'] = 'error';
                $data['caption'] = 'Unable to cancel friend request. Please try again later.';
            }

            return response()->json($data);
        } else {
            return 'No direct access allowed!';
        }
    }

    public function friendremove(Request $request) {
        // dd($request);
        if ($request->ajax()) {

            $to_user_id = $request->to_user_id;
            $comment = $request->comment;

            $user = $this->globaldata['user'];
            $user_id = $user->user_id;

            $friend = Friend::where('user_id', $user_id)->where('to_user_id', $to_user_id)->first();
            if(empty($friend)) {
                $friend = Friend::where('user_id', $to_user_id)->where('to_user_id', $user_id)->first();
            }
            $result = $friend->delete();

            if($result) {
                $data['type'] = 'success';
                $data['caption'] = 'Friendship removed!';
            }
            else {
                $data['type'] = 'error';
                $data['caption'] = 'Unable to remove friendship. Please try again later.';
            }

            return response()->json($data);
        } else {
            return 'No direct access allowed!';
        }
    }

    public function frienddecline(Request $request) {
        // dd($request);
        if ($request->ajax()) {

            $user_id = $request->user_id;

            $user = $this->globaldata['user'];
            $to_user_id = $user->user_id;

            $friend = Friend::where('user_id', $user_id)->where('to_user_id', $to_user_id)->first();
            $result = $friend->delete();

            if($result) {
                $data['type'] = 'success';
                $data['caption'] = 'Friendship request declined!';
            }
            else {
                $data['type'] = 'error';
                $data['caption'] = 'Unable to decline friendship request. Please try again later.';
            }

            return response()->json($data);
        } else {
            return 'No direct access allowed!';
        }
    }

    public function friendaccept(Request $request) {
        // dd($request);
        if ($request->ajax()) {

            $user_id = $request->user_id;

            $user = $this->globaldata['user'];
            $to_user_id = $user->user_id;

            $friend = Friend::where('user_id', $user_id)->where('to_user_id', $to_user_id)->first();
            $friend->status = 1;
            $result = $friend->update();

            if($result) {
                $data['type'] = 'success';
                $data['caption'] = 'Friendship request accepted!';
            }
            else {
                $data['type'] = 'error';
                $data['caption'] = 'Unable to accept friendship request. Please try again later.';
            }

            return response()->json($data);
        } else {
            return 'No direct access allowed!';
        }
    }

    public function friends($user_id = null) {
        $data   = [];
        $currentuser = $this->globaldata['user'];


        if (empty($user_id)) {
            $user = $currentuser;
        } else {
            $guestuser = User::findOrFail($user_id);
            $user = $guestuser;

        }

        // dd($user);

        $data['user'] = $user;
        $friends = Friend::where('status', 1)
                            ->where('to_user_id', $user->user_id)
                            ->orwhere(function($query) use($user) {
                                $query->where('user_id', $user->user_id)->where('status', 1);
                            })->latest()->get();
        $data['friends'] = $friends;

        $data['seosetting'] = SeoSetting::where('page', 'friend-request')->first();

        return view_front('friends', $data);
    }
}
