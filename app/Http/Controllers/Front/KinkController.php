<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Front\BaseController;
use App\Models\KinkMember;
use App\Models\Tag;
use Illuminate\Http\Request;
use App\Models\SeoSetting;

class KinkController extends BaseController
{
    public function index(){
        $user = $this->globaldata['user'];
        $data['kinks'] = Tag::where('status', '=', 1)->get();
        $data['kinkalphabetics'] =  $data['kinks']->groupBy(function($item) {
                return substr($item->name, 0,1);
            });

        $data['kinkmember'] = KinkMember::where('user_id', '=', $user->user_id)->get()->pluck('tag_id')->toArray();

        $totalmembers = $data['kinks']->sum('tagcount');
        $data['memberflag1'] = $totalmembers/3;
        $data['memberflag2'] = $totalmembers/4;

        $data['seosetting'] = SeoSetting::where('page', 'kink')->first();

        return view_front('kink.kink',$data);
    }

    public function submitkink(Request $request){

        if ($request->ajax()) {
            $user = $this->globaldata['user'];
            $tag = KinkMember::where('tag_id', '=', $request->tag_id )->where('user_id', $user->user_id)->first();

            if ($tag) {

                $tag->delete();

                $data["type"] = "success";
                $data['message'] = 'Deleted tag Successfully';

            }else{

                $kink_member            = new KinkMember();
                $kink_member->user_id   = $user->user_id;
                $kink_member->tag_id = $request->tag_id;
                $kink_member->save();

                $data["type"] = "success";
                $data['message'] = 'Save tag successfully';
            }
            return response()->json($data);
        }else{
            return 'No direct access allowed!';
        }
    }

    public function kinkmember($tag_id){

        // $data['kinkmembers'] = KinkMember::where('tag_id', '=', $tag_id)->with('kinkmember')->get();


        $data['kink_members'] =  KinkMember::where('tag_id', '=', $tag_id)->with('kinkmembers')->get()->groupBy(function($item) {
            return $item->tag_id;
        });

        $data['seosetting'] = SeoSetting::where('page', 'kink')->first();
        return view_front('kink.kink_member',$data);
    }

}
