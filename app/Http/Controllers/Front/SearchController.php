<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Front\BaseController;
use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\User;
use App\Models\AdPost;

class SearchController extends BaseController {
    

    public function search(Request $request){
        // dd($request);
        $data = [];
        $searchtext = trim($request->search);
        $type = trim($request->type);
        $data['searchtext'] = $searchtext;
        $data['searchtype'] = $type;

        if($type == 'group') {
            $groups = Group::search($searchtext)->get();
            $data['groups'] = $groups;

            return view_front('group.search',$data);
        }
        elseif($type == 'member') {
            $users = User::search($searchtext)->get();
            $data['users'] = $users;

            return view_front('member-search',$data);
        }
        else {
            $adposts = AdPost::search($searchtext)->get();
            $data['adpostcount'] = $adposts->count();
            $data['adposts'] = $adposts->groupBy(function($item) {
                return $item->created_at->format('Y-m-d');
            });

            return view_front('ad-search',$data);
        }
    }

}
