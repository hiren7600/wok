<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Front\BaseController;
use Illuminate\Http\Request;
use App\Models\UserMedia;

class VideoController extends BaseController
{
    public function index() {
        $usermedias = UserMedia::where('is_exposed', 1)->where('mediatype', 2)->with('comments')->with('videocomments')->with('user')->get();
        $data['usermedias'] = $usermedias;
        $data['user'] = $this->globaldata['user'];
        return view_front('videos', $data);
    }
}
