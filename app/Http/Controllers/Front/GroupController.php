<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Front\BaseController;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\Group;
use App\Models\GroupDiscussion;
use App\Models\GroupRequest;
use App\Models\GroupMember;
use App\Models\UserMedia;
use App\Models\GroupDiscussionComment;
use App\Models\GroupDiscussionLike;
use App\Models\GroupDiscussionView;
use App\Models\GroupDiscussionRead;
use App\Models\NotificationSetting;
use App\Models\User;
use App\Models\SeoSetting;
use App\Traits\SendgridTrait;

class GroupController extends BaseController
{
    public function index(){
        $user = $this->globaldata['user'];
        $user_id = $user->user_id;

        $mygroups = Group::where('user_id', $user->user_id)->get()->take(10);

        // $data['groups'] = Group::where('user_id','!=' , $user->user_id)->latest()->get();
        $groups = Group::leftjoin('group_discussions','group_discussions.group_id','=','groups.group_id')
                        ->leftjoin('group_discussion_comments','group_discussion_comments.group_discussion_id','=','group_discussions.group_discussion_id')
                        ->select('groups.*')
                        ->where(function($query)  use ($user_id) {
                                $query->Where('group_discussion_comments.user_id', $user_id);
                        })->groupBy('groups.group_id')->latest()->get()->take(10);

        $data['groups'] = $groups;
        $data['mygroups'] = $mygroups;

        $data['seosetting'] = SeoSetting::where('page', 'group')->first();

        if (!$groups->isEmpty() || !$mygroups->isEmpty()) {
            return view_front('group.index', $data);
        }else{
            return redirect('/groups');

        }
    }
    public function creategroup(){
        $data['seosetting'] = SeoSetting::where('page', 'group')->first();
        return view_front('group.group');
    }

    public function addownermembergroup(){
        $users = User::get();

        foreach($users as $user) {

            // $group_ids = [30];

            // foreach ($group_ids as  $group_id) {


            $groupmember = GroupMember::where('group_id', 46)->where('user_id', $user->user_id)->first();

            if(empty($groupmember)) {
                $GroupMember = new GroupMember();
                $GroupMember->group_id = 46;
                $GroupMember->user_id = $user->user_id;
                $GroupMember->save();
            }
            // }
        }
    }

    public function submitcreategroup(Request $request){
        if ($request->ajax()) {

            $rules = array(
                'title'         => 'required',
                'desc'          => 'required'
            );

            $messages = [
                'title.required'         => 'Please add title.',
                'desc.required'          => 'Please add description.'
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

                $user = $this->globaldata['user'];
                $create_group                 = new Group();
                $create_group->user_id        = $user->user_id;
                $create_group->title          = $request->title;
                $create_group->description    = $request->desc;
                $create_group->status         = $request->group_status;
                $create_group->is_read        = 0;
                $result                       = $create_group->save();

                if ($result) {
                    $groupmember = new GroupMember();
                    $groupmember->group_id = $create_group->group_id;
                    $groupmember->user_id = $user->user_id;
                    $groupmember->save();

                    $data["type"] = "success";
                    $data["redirectUrl"] = url('/discussion/'.$create_group->group_id);
                } else {
                    $data["type"] = "error";
                }
            }

            return response()->json($data);
        } else {
            return 'No direct access allowed!';
        }
    }

    public function discussion($group_id){

        $user       = $this->globaldata['user'];
        $user_id    = $user->user_id;

        $group = Group::where('group_id', $group_id)->first();
        $data['group'] = $group;

        $data['grouprequest'] = GroupRequest::where('group_id', $group_id)->where('user_id', $user_id)->first();
        $data['groupmember'] = GroupMember::where('group_id', $group_id)->where('user_id', $user_id)->first();

        $group_members = GroupMember::leftjoin('users','users.user_id','=','group_members.user_id')
            ->where('group_id', '=', $group_id)->orderBy('users.smallthumbfile', 'desc')->latest('group_members.created_at')->get();
        $data['group_members'] = $group_members->take(20);
        $data['group_member_count'] = $group_members->count();

        $sticky_discussions = $group->discussions->where('is_sticky', 1);
        $data['sticky_discussions'] = $sticky_discussions;

        $discussions = $group->discussions->where('is_sticky', 0);
        $data['discussions'] = $discussions;

        $data['user_image'] = UserMedia::where('mediatype', '=', 1)->where('user_id', '=', $group->user->user_id)->count();
        $data['user_video'] = UserMedia::where('mediatype', '=', 2)->where('user_id', '=', $group->user->user_id)->count();

        $isgroupread = GroupDiscussionRead::where('user_id', $user_id)->where('group_id', $group->group_id)->where('group_discussion_id', null)->first();

        if(empty($isgroupread)) {
            $groupdiscussionread = new GroupDiscussionRead();
            $groupdiscussionread->user_id = $user_id;
            $groupdiscussionread->group_id = $group->group_id;
            $groupdiscussionread->save();
        }
        $data['seosetting'] = SeoSetting::where('page', 'group')->first();
        return view_front('group.discussion_details',$data);
    }

    public function creatediscussion($group_id){

        $data['groups'] = Group::where('group_id', $group_id)->with('user')->first();
        $data['seosetting'] = SeoSetting::where('page', 'group')->first();
        return view_front('group.discussion', $data);
    }

    public function groupdetail(){

        $data['seosetting'] = SeoSetting::where('page', 'group')->first();
        return view_front('group.group-details');
    }

    // public function groupmarkread(Request $request){
    //     $user = $this->globaldata['user'];
    //     if ($request->ajax()) {
    //         $conversationmessage = ConversationMessage::where('conversation_id',$request->conversation_id)->where('user_id','!=' ,$user->user_id)->update(['is_read'=>1]);

    //         $data['type'] = 'success';
    //         return response()->json($data);
    //     }else{
    //         return 'No direct access allowed!';
    //     }
    // }



    public function submitcreatediscussion(Request $request){

        if ($request->ajax()) {
            $user = $this->globaldata['user'];

            $rules = [];
            $messages = [];

            if (!$request->hasFile('imagefile')) {
                $rules = array(
                    'title'         => 'required',
                    'desc'          => 'required'
                );
                $messages = [
                    'title.required'         => 'Please add title.',
                    'desc.required'          => 'Please add description.'
                ];
            }

            if ($request->hasFile('imagefile')) {
                $rules['imagefile'] = 'mimes:jpg,JPG,jpeg,JPEG,png,PNG';
                $messages['imagefile.mimes'] = 'Please select vaild image file.';
            }

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

                $user = $this->globaldata['user'];
                $user_id = $user->user_id;

                $group_discussion                   = new GroupDiscussion();
                $group_discussion->group_id         = $request->group_id;
                $group_discussion->user_id          = $user->user_id;
                $group_discussion->title            = $request->title;
                $group_discussion->content          = $request->desc;
                $group_discussion->is_sticky        = intval($request->sticky);
                $group_discussion->is_closed        = 0;
                $result                             = $group_discussion->save();
                if ($result) {
                    if ($request->hasFile('imagefile')) {
                        $imagefile   = $request->file('imagefile');
                        $extension = $imagefile->getClientOriginalExtension();

                        $imageName = time() . '.' . $imagefile->getClientOriginalExtension();

                        /******************* Original Image ******************/
                            if ($extension == 'jpeg' || $extension == 'JPEG' || $extension == 'jpg' || $extension == 'JPG') {
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
                            if ($extension == 'jpeg' || $extension == 'JPEG' || $extension == 'jpg' || $extension == 'JPG') {
                                $imgobject = imagejpeg($image, null, 50);
                            } elseif ($extension == 'png' || $extension == 'PNG') {
                                $bck = imagecolorallocate($image, 0, 0, 0);
                                imagecolortransparent($image, $bck);
                                imagealphablending($image, false);
                                imagesavealpha($image, true);
                                $imgobject = imagepng($image, null, 5);
                            }

                            $image_contents = ob_get_clean();

                            $imagePath = 'discussion/' . $group_discussion->group_discussion_id . '/' . $imageName;

                            $path = Storage::disk('s3')->put($imagePath, $image_contents);
                            $amazonImgUrl = Storage::disk('s3')->url($imagePath);
                        /******************* Original Image ******************/
                             //Thumb large image
                            $imgThumblarge = Image::make($image_contents);
                            $imgThumblarge->fit(config('constants.user_large_thumb_image_width'), config('constants.user_large_thumb_image_height'), function ($constraint) {
                                $constraint->aspectRatio();
                            })->encode($extension);

                            $imageLargePathThumb = 'discussion/'.$group_discussion->group_discussion_id.'/thumb/large/'.$imageName;

                            $largeThumbPath = Storage::disk('s3')->put($imageLargePathThumb, $imgThumblarge);
                            $amazonImgUrlLargeThumb = Storage::disk('s3')->url($imageLargePathThumb);
                        /******************* Thumb Image ******************/

                        $group_discussion->imagefile        = $amazonImgUrl;
                        $group_discussion->thumbimagefile   = $amazonImgUrlLargeThumb;
                        $group_discussion->update();

                    }
                    // if no image uploaded
                    $data["redirectUrl"] = url('/view-discussion/'.$group_discussion->group_discussion_id);
                    $data["type"] = "success";
                }else {
                    $data["type"] = "error";
                }
                return response()->json($data);
            }
        } else {
            return 'No direct access allowed!';
        }
    }

    public function groups(){
        $user = $this->globaldata['user'];

        $data['groups'] = Group::where('status', 0)->get()->SortByDesc('membercount');
        $data['seosetting'] = SeoSetting::where('page', 'group')->first();

        return view_front('group.groups', $data);
    }

    public function mostpopulargroup(){
        $user = $this->globaldata['user'];

        $data['groups'] = Group::where('status', 0)->get()->SortByDesc('commentcount');
        $data['seosetting'] = SeoSetting::where('page', 'group')->first();
        return view_front('group.most-popular-groups', $data);
    }

    public function newestgroup(){
        $user = $this->globaldata['user'];

        $data['groups'] = Group::where('status', 0)->latest()->get();
        $data['seosetting'] = SeoSetting::where('page', 'group')->first();
        return view_front('group.newest-groups', $data);
    }

    public function viewdiscussion($group_discussion_id){
        $user = $this->globaldata['user'];
        $group_discussion  = GroupDiscussion::where('group_discussion_id', $group_discussion_id)->with('user')->first();
        $data['group_discussion'] = $group_discussion;

        $groupdiscussionview = GroupDiscussionView::where('user_id', '=', $user->user_id)->where('group_discussion_id',$group_discussion_id)->first();

            if(empty($groupdiscussionview)) {
                $group_discussion_view                          = new GroupDiscussionView();
                $group_discussion_view->group_id                = $group_discussion->group_id;
                $group_discussion_view->group_discussion_id     = $group_discussion_id;
                $group_discussion_view->user_id                 = $user->user_id;
                $group_discussion_view->save();
            }

            $group_members = GroupMember::leftjoin('users','users.user_id','=','group_members.user_id')
            ->where('group_id', '=', $group_discussion->group_id)->orderBy('users.smallthumbfile', 'desc')->latest('group_members.created_at')->get();


        //  $group_members = GroupMember::where('group_id', '=', $group_discussion->group_id)->get();

         $data['group_members'] = $group_members->take(20);
         $data['group_member_count'] = $group_members->count();
         if (!empty($group_discussion->user)) {
            $data['user_image'] = UserMedia::where('mediatype', '=', 1)->where('user_id', '=', $group_discussion->user->user_id)->count();
            $data['user_video'] = UserMedia::where('mediatype', '=', 2)->where('user_id', '=', $group_discussion->user->user_id)->count();
         }



        $groupdiscussionlikes = GroupDiscussionLike::where('group_discussion_id', '=', $group_discussion_id)->get();
        $groupdiscussionlikesArr = $groupdiscussionlikes->pluck('user_id')->toArray();
        $data['discussion_like'] = $groupdiscussionlikes->count();

        $isVideoLiked = false;
        if(!empty($groupdiscussionlikesArr)) {
            if(in_array($this->globaldata['user']->user_id, $groupdiscussionlikesArr)) {
                $isVideoLiked = true;
            }
        }

        $data['isVideoLiked'] = $isVideoLiked;

        $data['groupmember'] = GroupMember::where('group_id', $group_discussion->group_id)->where('user_id', $user->user_id)->first();

        $isgroupdiscussionread = GroupDiscussionRead::where('user_id', $user->user_id)->where('group_id', $group_discussion->group_id)->where('group_discussion_id', $group_discussion->group_discussion_id)->first();

        if(empty($isgroupdiscussionread)) {
            $groupdiscussionread = new GroupDiscussionRead();
            $groupdiscussionread->user_id = $user->user_id;
            $groupdiscussionread->group_id = $group_discussion->group_id;
            $groupdiscussionread->group_discussion_id = $group_discussion->group_discussion_id;
            $groupdiscussionread->save();
        }
        $data['seosetting'] = SeoSetting::where('page', 'group')->first();

        return view_front('group.discussion_view',$data);
    }

    public function searchgroup(Request $request){
        $data = [];
        $searchtext = trim($request->search);

        $groups = Group::search($searchtext)->get();
        $data['searchtext'] = $searchtext;
        $data['groups'] = $groups;
        $data['seosetting'] = SeoSetting::where('page', 'group')->first();
        return view_front('group.search',$data);
    }

    public function requestgroup(Request $request){
        if ($request->ajax()) {


            $user       = $this->globaldata['user'];
            $user_id    = $user->user_id;
            $group_id   = trim($request->group_id);

            $grouprequest = GroupRequest::where('group_id', $group_id)->where('user_id', $user_id)->first();
            $isNew = true;
            if(!empty($grouprequest)) {
                $result = $grouprequest->delete();
                $isNew = false;
            }
            else {
                $grouprequest                   = new GroupRequest();
                $grouprequest->group_id         = $group_id;
                $grouprequest->user_id          = $user_id;
                $result                         = $grouprequest->save();
                $isNew = true;
            }

            if ($result) {
                $data["type"] = "success";
                if($isNew) {
                    $data["caption"] = "Join group request sent.";
                    $data["requesttype"] = "join-request";
                }
                else {
                    $data["caption"] = "Join group request cancelled.";
                    $data["requesttype"] = "cancel-request";
                }
            }
            else {
                $data["type"] = "error";
                $data["caption"] = "Unable to process your request. Please try again later!";
            }
            return response()->json($data);
        }
        else {
            return 'No direct access allowed!';
        }
    }

    public function discussioncomment(Request $request){
        if ($request->ajax()) {

            $rules = array(
                'discussion_comment'           => 'required',
            );

            $messages = [
                'discussion_comment.required'  => 'Please enter comment.',
            ];

            $validator  = Validator::make($request->all(), $rules, $messages);

            // if validation fails
            if ($validator->fails()) {
                $data['type'] = 'error';
                $data['caption'] = 'One or more invalid input found.';
                $data['errorfields'] = $validator->errors()->keys();
                $data['errormessage'] = $validator->errors()->all();
            }
            // if validation success
            else {
                $discussion_id = intval($request->discussion_id);
                $discussion_comment = trim($request->discussion_comment);
                $user = $this->globaldata['user'];

                $discussioncomment                      = new GroupDiscussionComment();
                $discussioncomment->group_discussion_id = $discussion_id;
                $discussioncomment->user_id             = $user->user_id;
                $discussioncomment->comments             = $discussion_comment;
                $result                                 = $discussioncomment->save();

                if ($result) {

                    $groupdiscussion = GroupDiscussion::find($discussion_id);
                    if(!empty($groupdiscussion)) {
                        $groupdiscussionread = GroupDiscussionRead::where('group_id', $groupdiscussion->group_id)->where('group_discussion_id', $groupdiscussion->group_discussion_id)->delete();
                    }


                    if ($request->hasFile('imagefile')) {
                        $imagefile   = $request->file('imagefile');
                        $extension = $imagefile->getClientOriginalExtension();

                        $imageName = time() . '.' . $imagefile->getClientOriginalExtension();

                        /******************* Original Image ******************/
                            if ($extension == 'jpeg' || $extension == 'JPEG' || $extension == 'jpg' || $extension == 'JPG') {
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
                            if ($extension == 'jpeg' || $extension == 'JPEG' || $extension == 'jpg' || $extension == 'JPG') {
                                $imgobject = imagejpeg($image, null, 50);
                            } elseif ($extension == 'png' || $extension == 'PNG') {
                                $bck = imagecolorallocate($image, 0, 0, 0);
                                imagecolortransparent($image, $bck);
                                imagealphablending($image, false);
                                imagesavealpha($image, true);
                                $imgobject = imagepng($image, null, 5);
                            }

                            $image_contents = ob_get_clean();

                            $imagePath = 'discussion/' . $discussion_id . '/comment/'.$discussioncomment->group_discussion_comment_id .'/' . $imageName;

                            $path = Storage::disk('s3')->put($imagePath, $image_contents);
                            $amazonImgUrl = Storage::disk('s3')->url($imagePath);
                        /******************* Original Image ******************/
                             //Thumb large image
                            $imgThumblarge = Image::make($image_contents);
                            $imgThumblarge->fit(config('constants.user_large_thumb_image_width'), config('constants.user_large_thumb_image_height'), function ($constraint) {
                                $constraint->aspectRatio();
                            })->encode($extension);

                            $imageLargePathThumb = 'discussion/'.$discussion_id. '/comment/'.$discussioncomment->group_discussion_comment_id.'/thumb/large/'.$imageName;

                            $largeThumbPath = Storage::disk('s3')->put($imageLargePathThumb, $imgThumblarge);
                            $amazonImgUrlLargeThumb = Storage::disk('s3')->url($imageLargePathThumb);
                        /******************* Thumb Image ******************/

                        $discussioncomment->imagefile        = $amazonImgUrl;
                        $discussioncomment->thumbimagefile   = $amazonImgUrlLargeThumb;
                        $discussioncomment->update();

                        $data["type"] = "success";
                    }

                    $groupDiscussion = GroupDiscussion::where('group_discussion_id', '=', $discussion_id)->first();
                    $current_url = url('/view-discussion/'.$discussion_id);

                    if ($user->user_id != $groupDiscussion->user_id ) {

                        userNotification($user->user_id,$groupDiscussion->user_id, 'discussioncomment' ,$current_url,$discussion_comment,'');

                        $notification_setting = NotificationSetting::where('user_id', $groupDiscussion->user_id)->first();

                        $subject = $user->username.' commented on your topic.';
                        $from_user = User::where('user_id', $groupDiscussion->user_id)->first();
                        $user_profile = url('/profile/'.$user->user_id);
                        if ($notification_setting->comment_topic == 1) {
                            if(!empty($from_user)) {
                                $api_response = SendgridTrait::sendEmail([
                                    //SET SENDGRID EMAIL TEMPLATE ID
                                    'templateid'  => 'd-5a673e2998cf48b88002b2d8904b330b',
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

                    // if no image uploaded
                    $data['comment'] = view_front('ajax.discussion-comment', ['discussioncomment' => $discussioncomment])->render();
                    $data['commentcounts'] = $groupdiscussion->allcomments->count();
                    // $data['media_id'] = $media_id;
                    $data['type'] = 'success';
                    $data['caption'] = 'Comment posted.';
                }
                else {
                    $data['type'] = 'error';
                    $data['caption'] = 'unable to comment feed. Please try again later!';
                }

            }
            return response()->json($data);
        } else {
            return 'No direct access allowed!';
        }
    }

    public function joingroup(Request $request){
        // dd($request);
        if ($request->ajax()) {

            $user       = $this->globaldata['user'];
            $user_id    = $user->user_id;
            $group_id   = trim($request->group_id);

            $groupmember = GroupMember::where('group_id', $group_id)->where('user_id', $user_id)->first();
            $isJoin = true;
            if(!empty($groupmember)) {
                $result = $groupmember->delete();
                $isJoin = false;
            }
            else {
                $groupmember                   = new GroupMember();
                $groupmember->group_id         = $group_id;
                $groupmember->user_id          = $user_id;
                $result                        = $groupmember->save();
                $isJoin = true;
            }

            if ($result) {
                $data["type"] = "success";
                if($isJoin) {
                    $data["caption"] = "Group joined.";
                    $data["requesttype"] = "group-join";
                }
                else {
                    $data["caption"] = "Group leaved.";
                    $data["requesttype"] = "group-leave";
                }
            }
            else {
                $data["type"] = "error";
                $data["caption"] = "Unable to process your request. Please try again later!";
            }
            return response()->json($data);
        }
        else {
             return 'No direct access allowed!';
        }
    }

    public function discussionrplcomment(Request $request){
        // dd($request->all());
        if ($request->ajax()) {

            $rules = array(
                'reply_comment'              => 'required',
            );

            $messages = [
                'reply_comment.required' => 'Please enter comment.',
            ];

            $validator  = Validator::make($request->all(), $rules, $messages);

            // if validation fails
            if ($validator->fails()) {
                $data['type'] = 'error';
                $data['caption'] = 'One or more invalid input found.';
                $data['errorfields'] = $validator->errors()->keys();
                $data['errormessage'] = $validator->errors()->all();
            }
            // if validation success
            else {
                $group_discussion_id            = intval($request->group_discussion_id);
                $group_discussion_comment_id            = intval($request->group_discussion_comment_id);
                $reply_comment                  = trim($request->reply_comment);
                $user                           = $this->globaldata['user'];

                $discussionrplcomment                                  = new GroupDiscussionComment();
                $discussionrplcomment->group_discussion_id             = $group_discussion_id;
                $discussionrplcomment->user_id                         = $user->user_id;
                $discussionrplcomment->parent_id                       = $group_discussion_comment_id;
                $discussionrplcomment->comments                        = $reply_comment;

                $result = $discussionrplcomment->save();

                if($result) {

                    $groupdiscussion  = GroupDiscussion::find($group_discussion_id);
                    if(!empty($groupdiscussion)) {
                        $groupdiscussionread = GroupDiscussionRead::where('group_id', $groupdiscussion->group_id)->where('group_discussion_id', $groupdiscussion->group_discussion_id)->delete();
                    }

                    $data['comment'] = view_front('ajax.discussion-comment-rpl', ['discussionrplcomment' => $discussionrplcomment])->render();
                    // $data['media_comment'] = MediaComment::where('media_id', '=', $media_id)->count();
                    // $data['media_id'] = $media_id;
                    $data['type'] = 'success';
                    $data['caption'] = 'Comment posted.';
                    $data['commentcounts'] = $groupdiscussion->allcomments->count();
                }
                else {
                    $data['type'] = 'error';
                    $data['caption'] = 'unable to comment feed. Please try again later!';
                }

            }
            return response()->json($data);
        } else {
            return 'No direct access allowed!';
        }
    }

    public function deletegroup( Request $request){
        if ($request->ajax()) {
            $group_id = $request->group_id;
            $group = Group::find($group_id);

            if (!empty($group)) {

                $user_id = $this->globaldata['user']->user_id;

                foreach ($group->discussions as $discussion) {
                    foreach($discussion->comments as $comment) {
                        if(!empty($comment->imagefile)) {
                            deleteS3Media($comment->imagefile);
                        }

                        if(!empty($comment->thumbimagefile)) {
                            deleteS3Media($comment->thumbimagefile);
                        }

                        $comment->delete();
                    }

                    foreach($discussion->likes as $like) {
                        $like->delete();
                    }

                    foreach($discussion->discussionviews as $view) {
                        $view->delete();
                    }

                    $discussion->delete();
                }

                foreach ($group->members as $member) {
                    $member->delete();
                }

                $group->delete();

                $data["type"] = "success";
                $data["redirectUrl"] = url('/group');

                $data["caption"] = "Group deleted successfully.";
            } else {
                $data["type"] = "error";
                $data["caption"] = "Unable to delete group. Please try again later.";
            }
            return response()->json($data);
        } else {
            return 'No direct access allowed!';
        }
    }

    public function editview($group_id) {

        $data = [];
        $group = Group::find($group_id);
        $user = $this->globaldata['user'];

        if(!empty($group)) {
            if($user->user_id == $group->user_id) {
                $data['group'] = $group;
                $data['seosetting'] = SeoSetting::where('page', 'group')->first();
                return view_front('group.group-edit', $data);
            }
            else {
                return abort('404');
            }
        }
        else {
            return abort('404');
        }
    }

    public function editsubmit(Request $request){
        // dd($request);
        if ($request->ajax()) {

            $rules = array(
                'title'         => 'required',
                'desc'          => 'required'
            );

            $messages = [
                'title.required'         => 'Please add title.',
                'desc.required'          => 'Please add description.'
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

                $group_id = intval($request->group_id);
                $group = Group::find($group_id);

                if($group) {
                    $group->title          = $request->title;
                    $group->description    = $request->desc;
                    $group->status         = intval($request->group_status);
                    $result                = $group->save();

                    if ($result) {
                        $data["type"] = "success";
                        $data["redirectUrl"] = url('/discussion/'.$group->group_id);
                    } else {
                        $data["type"] = "error";
                        $data["caption"] = "Unable to update group. Please try again later!";
                    }
                }
                else {
                    $data["type"] = "error";
                    $data["caption"] = "Unable to update group. Please try again later!";
                }

            }

            return response()->json($data);
        }
        else {
            return 'No direct access allowed!';
        }
    }

    public function deletediscussion( Request $request){
        if ($request->ajax()) {
            $group_discussion_id = $request->group_discussion_id;
            $discussion = GroupDiscussion::find($group_discussion_id);
            if (!empty($discussion)) {
                foreach($discussion->comments as $comment) {
                    if(!empty($comment->imagefile)) {
                        deleteS3Media($comment->imagefile);
                    }

                    if(!empty($comment->thumbimagefile)) {
                        deleteS3Media($comment->thumbimagefile);
                    }

                    $comment->delete();
                }

                foreach($discussion->likes as $like) {
                    $like->delete();
                }

                foreach($discussion->discussionviews as $view) {
                    $view->delete();
                }

                $discussion->delete();

                $data["type"] = "success";
                $data["redirectUrl"] = url('/discussion/'.$discussion->group_id);

                $data["caption"] = "Group deleted successfully.";
            } else {
                $data["type"] = "error";
                $data["caption"] = "Unable to delete group. Please try again later.";
            }

            return response()->json($data);
        } else {
            return 'No direct access allowed!';
        }
    }

    public function discussionlike(Request $request ){
        if ($request->ajax()) {

            $user= $this->globaldata['user'];
            $discussion_id = $request->discussion_id;

            $group_discussion = GroupDiscussionLike::where('group_discussion_id', '=', $discussion_id)->where('user_id',$user->user_id)->first();

            if ($group_discussion) {
                $result = GroupDiscussionLike::where('group_discussion_id', '=', $discussion_id)->where('user_id',$user->user_id)->delete();
            }
            else {
                $group_discussion_like = new GroupDiscussionLike();
                $group_discussion_like->group_discussion_id = $discussion_id;
                $group_discussion_like->user_id = $user->user_id;
                $result = $group_discussion_like->save();

                $groupDiscussion = GroupDiscussion::where('group_discussion_id', '=', $discussion_id)->first();
                $current_url = url('/view-discussion/'.$discussion_id);
                if ($user->user_id != $groupDiscussion->user_id ) {
                    userNotification($user->user_id,$groupDiscussion->user_id, 'discussionlike' ,$current_url,'',$groupDiscussion->title);

                    $subject = $user->username.' liked your discussion.';
                    $notification_setting = NotificationSetting::where('user_id', $groupDiscussion->user_id)->first();

                    $from_user = User::where('user_id', $groupDiscussion->user_id)->first();
                    $user_profile = url('/profile/'.$user->user_id);

                    if ($notification_setting->like_topic == 1) {
                        if(!empty($from_user)) {
                            $api_response = SendgridTrait::sendEmail([
                                //SET SENDGRID EMAIL TEMPLATE ID
                                'templateid'  => 'd-b4bd1e02a18e4ddab9b0f15a78a04b81',
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

            if($result){
                $DiscussionLikecounts = GroupDiscussionLike::where('group_discussion_id', '=', $discussion_id)->get()->count();
                $data["type"] = "success";
                $data["DiscussionLikecounts"] = $DiscussionLikecounts;
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

    public function discussionclose(Request $request){
        if ($request->ajax()) {
            $discussion_id = $request->discussion_id;

            $groupdiscussion = GroupDiscussion::find($discussion_id);
            $groupdiscussion->is_closed = $request->is_closed;
            $result = $groupdiscussion->update();

            if ($result) {
                $data["type"] = "success";
                $data["caption"] = "Sueccfully update topic status";
            } else {
                $data["type"] = "error";
                $data["caption"] = "Unable to update status. Please try again later!";
            }
            return response()->json($data);
        }else{
            return 'No direct access allowed!';
        }
    }

    public function groupmember($group_id){

        $data['group_members'] = GroupMember::where('group_id', '=', $group_id)->get();
        $data['seosetting'] = SeoSetting::where('page', 'group')->first();
        return view_front('group.group-member',$data);
    }

    public function editdiscussion($discussion_id){

        $data['group_discussion'] = GroupDiscussion::where('group_discussion_id', '=', $discussion_id)->first();

        $data['seosetting'] = SeoSetting::where('page', 'group')->first();

        return view_front('group.discussion-edit',$data);

    }
    public function submiteditdiscussion(Request $request ){

        if ($request->ajax()) {

            $rules = array(
                'title'         => 'required',
                'desc'          => 'required'
            );

            $messages = [
                'title.required'         => 'Please add title.',
                'desc.required'          => 'Please add description.'
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

                $discussion_id = intval($request->discussion_id);
                $groupdiscussion = GroupDiscussion::find($discussion_id);

                if ($request->hasFile('imagefile')) {
                    $imagefile   = $request->file('imagefile');
                    $extension = $imagefile->getClientOriginalExtension();

                    $imageName = time() . '.' . $imagefile->getClientOriginalExtension();

                    /******************* Original Image ******************/
                        if ($extension == 'jpeg' || $extension == 'JPEG' || $extension == 'jpg' || $extension == 'JPG') {
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
                        if ($extension == 'jpeg' || $extension == 'JPEG' || $extension == 'jpg' || $extension == 'JPG') {
                            $imgobject = imagejpeg($image, null, 50);
                        } elseif ($extension == 'png' || $extension == 'PNG') {
                            $bck = imagecolorallocate($image, 0, 0, 0);
                            imagecolortransparent($image, $bck);
                            imagealphablending($image, false);
                            imagesavealpha($image, true);
                            $imgobject = imagepng($image, null, 5);
                        }

                        $image_contents = ob_get_clean();

                        $imagePath = 'discussion/' . $groupdiscussion->group_discussion_id . '/' . $imageName;

                        $path = Storage::disk('s3')->put($imagePath, $image_contents);
                        $amazonImgUrl = Storage::disk('s3')->url($imagePath);
                    /******************* Original Image ******************/
                         //Thumb large image
                        $imgThumblarge = Image::make($image_contents);
                        $imgThumblarge->fit(config('constants.user_large_thumb_image_width'), config('constants.user_large_thumb_image_height'), function ($constraint) {
                            $constraint->aspectRatio();
                        })->encode($extension);

                        $imageLargePathThumb = 'discussion/'.$groupdiscussion->group_discussion_id.'/thumb/large/'.$imageName;

                        $largeThumbPath = Storage::disk('s3')->put($imageLargePathThumb, $imgThumblarge);
                        $amazonImgUrlLargeThumb = Storage::disk('s3')->url($imageLargePathThumb);
                    /******************* Thumb Image ******************/

                    $groupdiscussion->imagefile        = $amazonImgUrl;
                    $groupdiscussion->thumbimagefile   = $amazonImgUrlLargeThumb;
                    $groupdiscussion->update();

                }

                if($groupdiscussion) {
                    $groupdiscussion->title             = $request->title;
                    $groupdiscussion->content           = $request->desc;
                    $groupdiscussion->is_sticky         = intval($request->sticky);
                    $result                             = $groupdiscussion->save();

                    if ($result) {
                        $data["type"] = "success";
                        $data["redirectUrl"] = url('/discussion/'.$groupdiscussion->group_id);
                    } else {
                        $data["type"] = "error";
                        $data["caption"] = "Unable to update group. Please try again later!";
                    }
                }
                else {
                    $data["type"] = "error";
                    $data["caption"] = "Unable to update group. Please try again later!";
                }

            }

            return response()->json($data);
        }
        else {
            return 'No direct access allowed!';
        }
    }
}
