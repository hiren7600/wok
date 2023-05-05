<?php namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use App\Libraries\Api\Frontapi\Api;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use View;
use App\Models\Conversation;
use App\Models\Friend;
use App\Models\User;
use App\Models\UserNotification;

class BaseController extends Controller {

	protected $globaldata = [];

    public function __construct() {


        if(Auth::guard()->check()) {
            $user = Auth::guard()->user();
            $this->globaldata['user'] = $user;

            $conversationsCountcollection = Conversation::where('to_id',$user->user_id)
                                            ->orwhere(function($query) use($user) {
                                                $query->where('is_replied', 1)->where('from_id',$user->user_id);
                                            })
                                            ->with(['conversationmessages' => function($query) use ($user) {
                                                $query->where('is_read', 0)
                                                        ->where('user_id', '!=',$user->user_id)->get();
                                            }])->get();
            $conversationsCount = 0;
            if(!$conversationsCountcollection->isEmpty()) {
                foreach ($conversationsCountcollection as $conversationCnts) {
                    foreach ($conversationCnts->conversationmessages as $conversationCnt) {
                        $conversationsCount++;
                    }
                }
            }
            $this->globaldata['newMsgCounts'] = $conversationsCount;

            $friends = Friend::where('to_user_id', $user->user_id)->where('status', 0)->get();
            $this->globaldata['friendrequestcounts'] = $friends->count();
            $users = User::where('status', 1)->get();
            $this->globaldata['usercounts'] = $users->count();

            $this->globaldata['notificationcount'] = UserNotification::where('user_id', $user->user_id)->where('is_read', 0)->count();
            // dd($user->user_id );

            View::share('globaldata', $this->globaldata);
        }


    	View::share('globaldata', $this->globaldata);
    }


}
