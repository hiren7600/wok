<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Front\BaseController;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserMedia;
use App\Models\SeoSetting;

class ExposeController extends BaseController
{
    public function index() {
        $usermedias = UserMedia::where('is_exposed', 1)->with('comments')->with('videocomments')->with('user')->latest('updated_at')->get()->take(config('constants.perpage'));
        $data['usermedias'] = $usermedias;
        $data['user'] = $this->globaldata['user'];

        $data['seosetting'] = SeoSetting::where('page', 'exposed')->first();

        return view_front('expose', $data);
    }

    public function load(Request $request) {
        // if ajax request
        if ($request->ajax()) {

            $data   = [];
            $user = $this->globaldata['user'];

            $usermedias = UserMedia::where('is_exposed', 1)->with('comments')->with('videocomments')->with('user')->latest('updated_at');

            $itemcount = $usermedias->get()->count();
            $data['usermedias'] = $usermedias->paginate(config('constants.perpage'));


            $htmldata = view_front('ajax.images', $data)->render();

            return response()->json(['htmldata' => $htmldata, 'itemcount' => $itemcount]);
        }
        // if non ajax request
        else {
            return 'No direct access allowed!';
        }
    }
}
