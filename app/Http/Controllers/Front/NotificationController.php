<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Front\BaseController;
use App\Models\UserNotification;
use Illuminate\Http\Request;
use App\Models\SeoSetting;

class NotificationController extends BaseController
{
    public function index(){

        $user_id= $this->globaldata['user']->user_id;

        $data['user_notifications'] = UserNotification::where('user_id', '=', $user_id)->with('user')->latest()->get();

        $data['seosetting'] = SeoSetting::where('page', 'notification-list')->first();

        return view_front('notification-list' , $data);
    }

    public function notificationmarkread(Request $request){
        $user = $this->globaldata['user'];

        if ($request->ajax()) {
            $user_notification_id =  intval($request->user_notification_id);
            $usernotification = UserNotification::where('to_user_id','!=' ,$user->user_id)->update(['is_read'=>1]);

            $data['type'] = 'success';
            return response()->json($data);
        }else{
            return 'No direct access allowed!';
        }
    }

    // public function notificationRecivemail(Request $request){

    // }
}
