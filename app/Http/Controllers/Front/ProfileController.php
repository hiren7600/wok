<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Front\BaseController;
use App\Models\BlockUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\ImageTag;
use App\Models\UserMedia;
use App\Models\MediaComment;
use App\Models\UserMediaLike;
use App\Models\Comment;
use App\Models\Conversation;
use App\Models\UserMediaView;
use App\Models\Post;
use App\Models\Usertoken;
use App\Models\Friend;
use App\Models\KinkMember;
use App\Models\UserActivity;
use App\Models\Follow;
use App\Models\Group;
use App\Models\GroupDiscussion;
use App\Models\GroupDiscussionComment;
use App\Models\GroupDiscussionLike;
use App\Models\GroupDiscussionView;
use App\Models\GroupMember;
use App\Models\NotificationSetting;
use PhpParser\Node\Stmt\GroupUse;
use App\Models\SeoSetting;
use App\Models\UserNotification;
use App\Traits\SendgridTrait;

class ProfileController extends BaseController
{
    public function profile($userid = null)
    {
        $data   = [];
        $currentuser = $this->globaldata['user'];
        $guestuser = null;
        $sentRequest = null;
        $receivedRequest = null;
        $following = null;

        // dd($currentuser->membergroups);

        if (empty($userid) ) {
            $data['user'] = $currentuser;
        } else {
            $guestuser = User::findOrFail($userid);
            $data['user'] = $guestuser;

            $receivedRequest = $currentuser->receivedfriendrequest()->where('user_id', $guestuser->user_id)->first();
            $sentRequest = $currentuser->sentfriendrequest()->where('to_user_id', $guestuser->user_id)->first();
            $following = $currentuser->following()->where('to_user_id', $guestuser->user_id)->first();
        }

        $data['user_block'] = BlockUser::where('to_user_id', $userid)->first();

        // $check_block_user = BlockUser::where('to_user_id', $currentuser->user_id)->where('user_id', $userid)->with('user')->first();
        // $data['check_block_user'] = $check_block_user;
        // if ($check_block_user) {
        //     return view_front('profile/block_user',$data);
        // }

        $data['followers'] = Follow::where('to_user_id', $data['user']->user_id)->get()->take(5);
        $data['followings'] = Follow::where('user_id', $data['user']->user_id)->get()->take(5);


        $data['receivedRequest'] = $receivedRequest;
        $data['sentRequest'] = $sentRequest;
        $data['following'] = $following;

        $data['address']  =  string_explode_implode($data['user']['address']);

        $friend = Friend::where('status', 1)
                            ->where('user_id', $currentuser->user_id)
                            ->where('to_user_id', $userid)
                            ->orwhere(function($query) use($currentuser, $userid) {
                                $query->where('user_id', $userid)->where('to_user_id', $currentuser->user_id)->where('status', 1);
                            })->first();
        if ($friend) {
            $user_image = UserMedia::where('mediatype', '=', 1)->where('user_id', '=', $data['user']['user_id'])->latest()->get();

            $user_video = UserMedia::where('mediatype', '=', 2)->where('user_id', '=', $data['user']['user_id'])->latest()->get();
        }else if($userid == $currentuser->user_id || $userid == null){
            $user_image = UserMedia::where('mediatype', '=', 1)->where('user_id', '=', $data['user']['user_id'])->latest()->get();

            $user_video = UserMedia::where('mediatype', '=', 2)->where('user_id', '=', $data['user']['user_id'])->latest()->get();
        }else{
            $user_image = UserMedia::where('mediatype', '=', 1)->where('user_id', '=', $data['user']['user_id'])->where('showto',0)->latest()->get();

            $user_video = UserMedia::where('mediatype', '=', 2)->where('user_id', '=', $data['user']['user_id'])->where('showto',0)->latest()->get();
        }

        $data['user_image_count'] = $user_image->count();
        $data['user_image'] = $user_image->take(20);

        // $user_video = UserMedia::where('mediatype', '=', 2)->where('user_id', '=', $data['user']['user_id'])->latest()->get();
        $data['user_video_count'] = $user_video->count();
        $data['user_video'] = $user_video->take(20);

        $data['gender'] = config('constants.gender');

        // $friends = Friend::where('status', 1)->where('user_id', $data['user']->user_id)->orWhere('to_user_id', $data['user']->user_id)->get();
        $user = $data['user'];
        $friends = Friend::where('status', 1)
                            ->where('to_user_id', $user->user_id)
                            ->orwhere(function($query) use($user) {
                                $query->where('user_id', $user->user_id)->where('status', 1);
                            })->latest()->get();

        $data['friendcounts'] = $friends->count();
        $data['friends'] = $friends;

        $data['member_kinks'] = KinkMember::where('user_id', $data['user']->user_id)->with('membertag')->get();

        $memberkinkArr = [];
        foreach ($data['member_kinks'] as $member_kink){
            $memberkinkArr[] = $member_kink->membertag->name;

        }

        $data['member_kink'] = implode(', ',$memberkinkArr);

        $data['seosetting'] = SeoSetting::where('page', 'profile')->first();

        return view_front('profile/profile', $data);
    }

    public function blockUserView($user_id){

        $currentuser = $this->globaldata['user'];

        $data['check_block_user'] = BlockUser::where('to_user_id',$currentuser->user_id )->where('user_id', $user_id )->with('user')->first();
        $check_block_user = $data['check_block_user'];

        if (!empty($check_block_user)) {
            return view_front('profile/block_user',$data);
        }else{
            return redirect('profile/'.$user_id);
        }
    }

    public function profilesubmit(Request $request)
    {
        // dd($request);
        if ($request->ajax()) {

            $rules = array(
                'imagefile'     => 'required|mimes:jpg,JPG,jpeg,JPEG,png,PNG,gif,GIF',
            );

            $messages = [
                'imagefile.required'    => 'Please select profile image.',
                'imagefile.mimes'       => 'Please select jpg, jpeg, png or gif file.',
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
                $user_id = $user->user_id;
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

                        $imagePath = 'users/' . $user_id . '/' . $imageName;

                        $path = Storage::disk('s3')->put($imagePath, $image_contents);
                        $amazonImgUrl = Storage::disk('s3')->url($imagePath);
                    /******************* Original Image ******************/

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


                    $user = User::findOrFail($user_id);
                    $user->imagefile = $amazonImgUrl;
                    $user->smallthumbfile = $amazonImgUrlSmallThumb;
                    $user->mediumthumbfile = $amazonImgUrlMediumThumb;
                    $user->largethumbfile = $amazonImgUrlLargeThumb;
                    $user->update();

                    $user_media = new UserMedia();
                    $user_media->user_id = $user_id;
                    $user_media->mediafile = $amazonImgUrl;
                    $user_media->smallthumbfile     = $amazonImgUrlSmallThumb;
                    $user_media->mediumthumbfile    = $amazonImgUrlMediumThumb;
                    $user_media->largethumbfile     = $amazonImgUrlLargeThumb;
                    $user_media->mediatype = 1;
                    $user_media->save();


                    $data['image'] = $amazonImgUrl;
                    $data["type"] = "success";
                }
                // if no image uploaded
                else {
                    $data["type"] = "error";
                }
            }
            return response()->json($data);
        } else {
            return 'No direct access allowed!';
        }
    }

    public function about()
    {
        $user_id = $this->globaldata['user']->user_id;

        $user = User::findOrFail($user_id);

        $data   = [];
        $data['gender']         = config('constants.gender');
        $data['relationships']  = config('constants.relationships');
        $data['orientations']   = config('constants.orientations');
        $data['role']           = config('constants.role');
        $data['looking_for']    = config('constants.looking_for');
        $data['user']           = $user;

        $data['seosetting'] = SeoSetting::where('page', 'about-me')->first();

        return view_front('profile/about', $data);
    }

    public function aboutedit(Request $request)
    {
        $role_data = $request->role_new;
        $rolearray = $request->role;
        if ($request->ajax()) {
            if (!empty($role_data)) {
                $roledata = array_push($rolearray, $role_data);
            }
            $roledata = collect($rolearray)->implode(', ');
            $dateofbirth = date("Y-m-d", strtotime($request->dateofbirth));

            $looking_for = collect($request['looking_for'])->implode(', ');

            $user_id = $this->globaldata['user']->user_id;
            $user = User::findOrFail($user_id);
            $user->username                 = $request->username;
            $user->about                    = htmlspecialchars($request->description);
            $user->looking_for              = $looking_for;
            $user->dob                      = $dateofbirth;
            $user->gender                   = $request->gender;
            $user->sexual_orientation       = $request->sexual_orientation;
            $user->relationship_status      = $request->relationship_status;
            $user->role                     = $roledata;
            $user->address                  = $request->city;
            $user->full_address             = $request->full_address;
            $result = $user->update();

            if ($result) {
                $data["type"] = "success";
            } else {
                $data["type"] = "error";
            }
            return response()->json($data);
        } else {
            return 'No direct access allowed!';
        }
    }

    public function filters()
    {
        $data['seosetting'] = SeoSetting::where('page', 'filters')->first();
        return view_front('profile/filters', $data);
    }

    public function uploadimages()
    {
        $image_tag = ImageTag::where('status', '=', 1)->get()->pluck('tag', 'tag')->toArray();
        $data['image_tag'] = $image_tag;

        $user_id = $this->globaldata['user']->user_id;
        $data['user_media'] = UserMedia::where('mediatype', '=', 1)->where('user_id', '=', $user_id)->latest()->get();
        $data['seosetting'] = SeoSetting::where('page', 'upload-photo')->first();
        return view_front('profile/uploadimages', $data);
    }

    public function userimages($userid = null)
    {
        $data   = [];
        $currentuser = $this->globaldata['user'];
        if (empty($userid)) {
            $data['user'] = $currentuser;
        } else {
            $data['user'] = User::findOrFail($userid);
        }

        $friend = Friend::where('status', 1)
                            ->where('user_id', $currentuser->user_id)
                            ->where('to_user_id', $userid)
                            ->orwhere(function($query) use($currentuser, $userid) {
                                $query->where('user_id', $userid)->where('to_user_id', $currentuser->user_id)->where('status', 1);
                            })->first();
        if ($friend) {

            $user_media = UserMedia::where('mediatype', '=', 1)->where('user_id', '=', $data['user']['user_id'])->latest()->get();

            $user_video = UserMedia::where('mediatype', '=', 2)->where('user_id', '=', $data['user']['user_id'])->count();

        }else if($userid == $currentuser->user_id || $userid == null){

            $user_media = UserMedia::where('mediatype', '=', 1)->where('user_id', '=', $data['user']['user_id'])->latest()->get();

            $user_video = UserMedia::where('mediatype', '=', 2)->where('user_id', '=', $data['user']['user_id'])->count();

        }else{

            $user_media = UserMedia::where('mediatype', '=', 1)->where('user_id', '=', $data['user']['user_id'])->where('showto',0)->latest()->get();

            $user_video = UserMedia::where('mediatype', '=', 2)->where('user_id', '=', $data['user']['user_id'])->where('showto',0)->count();
        }

        $data['user_media'] = $user_media->take(config('constants.perpage'));
        $data['user_video'] = $user_video;

        $data['seosetting'] = SeoSetting::where('page', 'user-images')->first();

        return view_front('profile/user-image', $data);
    }

    public function loaduserimages(Request $request, $userid) {
        // if ajax request
        if ($request->ajax()) {

            $data   = [];

            $currentuser = $this->globaldata['user'];
            if (empty($userid)) {
                $user = $currentuser;
            } else {
                $user = User::findOrFail($userid);
            }

            $friend = Friend::where('status', 1)
                                ->where('user_id', $currentuser->user_id)
                                ->where('to_user_id', $userid)
                                ->orwhere(function($query) use($currentuser, $userid) {
                                    $query->where('user_id', $userid)->where('to_user_id', $currentuser->user_id)->where('status', 1);
                                })->first();
            if ($friend) {

                $user_media = UserMedia::where('mediatype', '=', 1)->where('user_id', '=', $user->user_id)->latest();

            }else if($userid == $currentuser->user_id || $userid == null){

                $user_media = UserMedia::where('mediatype', '=', 1)->where('user_id', '=', $user->user_id)->latest();

            }else{

                $user_media = UserMedia::where('mediatype', '=', 1)->where('user_id', '=', $user->user_id)->where('showto',0)->latest();

            }


            $itemcount = $user_media->get()->count();
            $data['user'] = $user;
            $data['user_media'] = $user_media->paginate(config('constants.perpage'));


            $htmldata = view_front('ajax.user-image', $data)->render();

            return response()->json(['htmldata' => $htmldata, 'itemcount' => $itemcount]);
        }
        // if non ajax request
        else {
            return 'No direct access allowed!';
        }
    }

    public function uploadimagesubmit(Request $request)
    {
        // dd($request);
        if ($request->ajax()) {

            $rules = array(
                'imagefile'     => 'required|mimes:jpg,JPG,jpeg,JPEG,png,PNG,gif,GIF',
                'tnc'           => 'required'
            );

            $messages = [
                'imagefile.required'    => 'Please select image.',
                'imagefile.mimes'       => 'Please select jpg, jpeg, png or gif file.',
                'tnc.required'          => 'Please select terms and condition.'
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

                if ($request->hasFile('imagefile')) {
                    $mediafile = $request->file('imagefile');
                    $extension = $mediafile->getClientOriginalExtension();

                    $user = $this->globaldata['user'];
                    $imageName = time() . '.' . $extension;

                    /******************* Original Image ******************/
                        if ($extension == 'jpeg' || $extension == 'JPEG'  || $extension == 'jpg' || $extension == 'JPG') {
                            $image = imagecreatefromjpeg($mediafile);
                        } elseif ($extension == 'png' || $extension == 'PNG') {
                            $image = imagecreatefrompng($mediafile);
                        }

                        $exif = @exif_read_data($mediafile);
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
                        //     $thumbImage = imagecreatefromjpeg($mediafile);
                        // } elseif ($extension == 'png' || $extension == 'PNG') {
                        //     $thumbImage = imagecreatefrompng($mediafile);
                        // }

                        // $exif = @exif_read_data($mediafile);
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
                        // $imgThumblarge->fit(config('constants.user_large_thumb_image_width'), config('constants.user_large_thumb_image_height'), function ($constraint) {
                        //     $constraint->aspectRatio();
                        // })->encode($extension);

                        $imgThumblarge->resize(config('constants.user_large_thumb_image_width'), null, function ($constraint) {
                            $constraint->aspectRatio();
                        })->encode($extension);

                        $imageLargePathThumb = 'users/'.$user->user_id.'/thumb/large/'.$imageName;

                        $largeThumbPath = Storage::disk('s3')->put($imageLargePathThumb, $imgThumblarge);
                        $amazonImgUrlLargeThumb = Storage::disk('s3')->url($imageLargePathThumb);
                    /******************* Thumb Image ******************/

                    $tag = null;
                    if (!empty($request->tags)) {
                        $tag = implode(",", $request->tags);
                    }

                    $user_media = new UserMedia();
                    $user_media->user_id            = $user->user_id;
                    $user_media->mediafile          = $amazonImgUrl;
                    $user_media->smallthumbfile     = $amazonImgUrlSmallThumb;
                    $user_media->mediumthumbfile    = $amazonImgUrlMediumThumb;
                    $user_media->largethumbfile     = $amazonImgUrlLargeThumb;
                    $user_media->mediatype          = 1;
                    $user_media->tag                = $tag;
                    $user_media->showto             = $request->showto;
                    $user_media->caption            = $request->caption;
                    $user_media->is_exposed         = 0;
                    $user_media->save();

                    // $activity = $user->username.' uploaded a new <a href="{{url('/profile/'.$user->user_id)}}"> photo</a>';

                    // userActivity($user->user_id,'uploaded',$activity);

                    $data['image'] = $amazonImgUrl;
                    $data["type"] = "success";

                }
                // if no image uploaded
                else {
                    $data["type"] = "error";
                    $data["caption"] = "Unable to upload image. Please try again later.";
                }
            }

            return response()->json($data);
        } else {
            return 'No direct access allowed!';
        }
    }

    public function imagedetail($mediaid, $userid = null)
    {
        $data   = [];
        $currentuser = $this->globaldata['user'];
        if (empty($userid)) {
            $data['user'] = $currentuser;
        } else {
            $data['user'] = User::findOrFail($userid);
        }

        $single_media = UserMedia::where('media_id', '=', $mediaid)->where('mediatype', '=', 1)->first();
        if($single_media) {
            $image_tag = ImageTag::where('status', '=', 1)->get()->pluck('tag', 'tag')->toArray();
            $data['image_tag'] = $image_tag;
            $data['single_media'] = $single_media;

            $friend = Friend::where('status', 1)
                    ->where('user_id', $currentuser->user_id)
                    ->where('to_user_id', $userid)
                    ->orwhere(function($query) use($currentuser, $userid) {
                        $query->where('user_id', $userid)->where('to_user_id', $currentuser->user_id)->where('status', 1);
                    })->first();
            if ($friend) {
                $data['user_image'] = UserMedia::where('mediatype', '=', 1)->where('user_id', '=', $data['user']->user_id)->latest()->get();

                $data['user_video'] = UserMedia::where('mediatype', '=', 2)->where('user_id', '=', $data['user']->user_id)->count();

            }else if($userid == $currentuser->user_id || $userid == null){
                $data['user_image'] = UserMedia::where('mediatype', '=', 1)->where('user_id', '=', $data['user']->user_id)->latest()->get();

                $data['user_video'] = UserMedia::where('mediatype', '=', 2)->where('user_id', '=', $data['user']->user_id)->count();

            }else{

                $data['user_image'] = UserMedia::where('mediatype', '=', 1)->where('user_id', '=', $data['user']->user_id)->where('showto',0)->latest()->get();

                $data['user_video'] = UserMedia::where('mediatype', '=', 2)->where('user_id', '=', $data['user']->user_id)->where('showto',0)->count();
            }

            $userimageArr = $data['user_image']->pluck('media_id')->toArray();

            $usermediaview = UserMediaView::where('user_id', '=', $currentuser->user_id)->where('media_id',$mediaid)->first();

            if(empty($usermediaview)) {
                $user_media_view               = new UserMediaView();
                $user_media_view->media_id     = $mediaid;
                $user_media_view->user_id      = $currentuser->user_id;
                $user_media_view->save();
            }
            $data['usermediaview'] = $usermediaview = UserMediaView::where('media_id',$mediaid)->count();

            $nextId = null;
            $prevId = null;
            $key = array_search($mediaid, $userimageArr);

            if( ($key-1) < 0 ) {
                $prevId = $userimageArr[count($userimageArr) - 1];
            }
            else {
                $prevId = $userimageArr[$key-1];
            }

            if( ($key+1) > (count($userimageArr) - 1) ) {
                $nextId = $userimageArr[0];
            }
            else {
                $nextId = $userimageArr[$key+1];
            }

            if($this->globaldata['user']->user_id != $data['user']->user_id) {
                $data['prevId'] = $prevId.'/'.$data['user']->user_id;
                $data['nextId'] = $nextId.'/'.$data['user']->user_id;
            }
            else {
                $data['prevId'] = $prevId;
                $data['nextId'] = $nextId;
            }

            $data['media_comment'] = MediaComment::where('media_id', '=', $mediaid)->count();

            $usermedialikes = UserMediaLike::where('media_id', '=', $mediaid)->get();
            $usermedialikesArr = $usermedialikes->pluck('user_id')->toArray();
            $data['user_video_like'] = $usermedialikes->count();

            $isVideoLiked = false;
            if(!empty($usermedialikesArr)) {
                if(in_array($this->globaldata['user']->user_id, $usermedialikesArr)) {
                    $isVideoLiked = true;
                }
            }

            $data['isVideoLiked'] = $isVideoLiked;

            $data['seosetting'] = SeoSetting::where('page', 'image-detail')->first();
            return view_front('profile/image-detail', $data);
        }
        else {
            abort('404');
        }

    }

    public function imagedetailsubmit(Request $request)
    {
        // dd($request->all());
        if ($request->ajax()) {
            $rules = array(
                'image_caption'  => 'required'
            );
            $messages = [
                'image_caption.required' => 'Please add Video Caption.'
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
                $media_id = $request->media_id;
                $user_media = UserMedia::find($media_id);
                $user_media->caption = $request->image_caption;
                $result = $user_media->update();

                if ($result) {
                    $data["type"] = "success";
                } else {
                    $data["type"] = "error";
                }
                return response()->json($data);
            }
        } else {
            return 'No direct access allowed!';
        }
    }

    public function imagetagupdate(Request $request)
    {
        // dd($request->all());
        if ($request->ajax()) {

            $mediaid = $request->media_id;
            if ($mediaid) {
                $tag = null;
                if (!empty($request->tags)) {
                    $tag = implode(",", $request->tags);
                }
                $user_media = UserMedia::find($mediaid);
                $user_media->tag = $tag;
                 $user_media->update();
                $data["type"] = "success";
            } else {
                $data["type"] = "error";
                $data["caption"] = "Unable to update tag. Please try again later.";
            }
            return response()->json($data);
        } else {
            return 'No direct access allowed!';
        }
    }

    public function deleteimage(Request $request)
    {
        if ($request->ajax()) {
            $mediaid = $request->media_id;
            if ($mediaid) {
                $user_id = $this->globaldata['user']->user_id;
                $single_media = UserMedia::where('media_id', '=', $mediaid)->first();
                if (!empty($single_media->mediafile)) {
                    deleteS3Media($single_media->mediafile);
                }

                if (!empty($single_media->smallthumbfile)) {
                    deleteS3Media($single_media->smallthumbfile);
                }

                if (!empty($single_media->mediumthumbfile)) {
                    deleteS3Media($single_media->mediumthumbfile);
                }

                if (!empty($single_media->largethumbfile)) {
                    deleteS3Media($single_media->largethumbfile);
                }

                $single_media = UserMedia::where('media_id', '=', $mediaid)->delete();
                $data["type"] = "success";
            } else {
                $data["type"] = "error";
                $data["caption"] = "Unable to delete image. Please try again later.";
            }
            return response()->json($data);
        } else {
            return 'No direct access allowed!';
        }
    }

    public function exposedimage(Request $request)
    {
        if ($request->ajax()) {
            $mediaid = $request->media_id;
            if ($mediaid) {
                $user_media = UserMedia::find($mediaid);
                $user_media->is_exposed = $request->exposed;
                 $user_media->update();
                $data["type"] = "success";
            } else {
                $data["type"] = "error";
                $data["caption"] = "Unable to exposed image. Please try again later.";
            }
            return response()->json($data);
        } else {
            return 'No direct access allowed!';
        }
    }

    public function imageshow(Request $request)
    {
        if ($request->ajax()) {
            $mediaid = $request->media_id;
            if ($mediaid) {
                $user_media = UserMedia::find($mediaid);
                $user_media->showto = $request->image_show;
                 $user_media->update();
                $data["type"] = "success";
            } else {
                $data["type"] = "error";
                $data["caption"] = "Unable to chnage status. Please try again later.";
            }
            return response()->json($data);
        } else {
            return 'No direct access allowed!';
        }
    }

    public function uploadvideos()
    {
        $image_tag = ImageTag::where('status', '=', 1)->get()->pluck('tag', 'tag')->toArray();
        $data['image_tag'] = $image_tag;

        $user_id = $this->globaldata['user']->user_id;
        $data['user_media'] = UserMedia::where('mediatype', '=', 2)->where('user_id', '=', $user_id)->latest()->get();
        $data['seosetting'] = SeoSetting::where('page', 'upload-videos')->first();
        return view_front('profile/uploadvideos', $data);
    }

    public function uploadvideossubmit(Request $request)
    {
        // dd($request);
        if ($request->ajax()) {
            $rules = array(
                'mediafile'     => 'required|mimes:m4v,M4V,mov,MOV,mp4,MP4,wmv,WMV,flv,FLV',
                'tnc'           => 'required'
            );

            $messages = [
                'mediafile.required'    => 'Please select video.',
                'mediafile.mimes'       => 'Please select m4v, mov, mp4, wmv or flv file.',
                'tnc.required'          => 'Please select terms and condition.'
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

                if ($request->hasFile('mediafile')) {
                    $mediafile = $request->file('mediafile');
                    $extension = $mediafile->getClientOriginalExtension();

                    $user = $this->globaldata['user'];
                    $time = time();
                    $videoName = $time . '.' . $extension;

                    $videoPath = 'users/' . $user->user_id . '/videos/' . $videoName;

                    $path = Storage::disk('s3')->put($videoPath, file_get_contents($mediafile));
                    $amazonImgUrl = Storage::disk('s3')->url($videoPath);

                    $thumb = file_get_contents($request->thumbimage);
                    $thumbName = $time . '.jpg';
                    $thumbPath = 'users/' . $user->user_id . '/videos/thumbs/' . $thumbName;

                    $path = Storage::disk('s3')->put($thumbPath, $thumb);
                    $amazonThumbImgUrl = Storage::disk('s3')->url($thumbPath);

                    $tag = null;
                    if (!empty($request->tags)) {
                        $tag = implode(",", $request->tags);
                    }

                    $user_media = new UserMedia();
                    $user_media->user_id        = $user->user_id;
                    $user_media->mediafile      = $amazonImgUrl;
                    $user_media->videothumbfile = $amazonThumbImgUrl;
                    $user_media->mediatype      = 2;
                    $user_media->is_exposed     = 0;
                    $user_media->showto         = $request->showto;
                    $user_media->caption        = $request->caption;
                    $user_media->tag            = $tag;
                    $user_media->save();


                    $data['image'] = $amazonImgUrl;
                    $data["type"] = "success";
                }
                // if no image uploaded
                else {
                    $data["type"] = "error";
                    $data["caption"] = "Unable to upload video. Please try again later.";
                }
            }

            return response()->json($data);
        } else {
            return 'No direct access allowed!';
        }
    }

    public function deletevideo(Request $request)
    {
        if ($request->ajax()) {
            $mediaid = $request->media_id;
            if ($mediaid) {
                $user_id = $this->globaldata['user']->user_id;
                $single_media = UserMedia::where('media_id', '=', $mediaid)->first();

                if (!empty($single_media->videothumbfile)) {
                    deleteS3Media($single_media->videothumbfile);
                }

                if (!empty($single_media->mediafile)) {
                    deleteS3Media($single_media->mediafile);
                }
                $single_media = UserMedia::where('media_id', '=', $mediaid)->delete();
                $data["type"] = "success";
            } else {
                $data["type"] = "error";
                $data["caption"] = "Unable to delete video. Please try again later.";
            }
            return response()->json($data);
        } else {
            return 'No direct access allowed!';
        }
    }

    public function videotagupdate(Request $request)
    {
        // dd($request->all());
        if ($request->ajax()) {

            $mediaid = $request->media_id;
            if ($mediaid) {
                $tag = null;
                if (!empty($request->tags)) {
                    $tag = implode(",", $request->tags);
                }
                $user_media = UserMedia::find($mediaid);
                $user_media->tag = $tag;
                 $user_media->update();
                $data["type"] = "success";
            } else {
                $data["type"] = "error";
                $data["caption"] = "Unable to update tag. Please try again later.";
            }
            return response()->json($data);
        } else {
            return 'No direct access allowed!';
        }
    }

    public function exposedvideo(Request $request)
    {
        if ($request->ajax()) {
            $mediaid = $request->media_id;
            if ($mediaid) {
                $user_media = UserMedia::find($mediaid);
                $user_media->is_exposed = $request->exposed;
                 $user_media->update();
                $data["type"] = "success";
            } else {
                $data["type"] = "error";
                $data["caption"] = "Unable to exposed video. Please try again later.";
            }
            return response()->json($data);
        } else {
            return 'No direct access allowed!';
        }
    }

    public function videoshow(Request $request)
    {
        if ($request->ajax()) {
            $mediaid = $request->media_id;
            if ($mediaid) {
                $user_media = UserMedia::find($mediaid);
                $user_media->showto = $request->video_show;
                 $user_media->update();
                $data["type"] = "success";
            } else {
                $data["type"] = "error";
                $data["caption"] = "Unable to chnage status. Please try again later.";
            }
            return response()->json($data);
        } else {
            return 'No direct access allowed!';
        }
    }

    public function videodetail($mediaid, $userid = null)
    {

        $data   = [];
        $currentuser = $this->globaldata['user'];
        if (empty($userid)) {
            $data['user'] = $currentuser;
        } else {
            $data['user'] = User::findOrFail($userid);
        }

        $single_media = UserMedia::where('media_id', '=', $mediaid)->where('mediatype', '=', 2)->first();
        if($single_media) {
            $image_tag = ImageTag::where('status', '=', 1)->get()->pluck('tag', 'tag')->toArray();
            $data['image_tag'] = $image_tag;
            $data['single_media'] = $single_media;

            // dd($data['user_video']);


            $friend = Friend::where('status', 1)
                ->where('user_id', $currentuser->user_id)
                ->where('to_user_id', $userid)
                ->orwhere(function($query) use($currentuser, $userid) {
                    $query->where('user_id', $userid)->where('to_user_id', $currentuser->user_id)->where('status', 1);
                })->first();
            if ($friend) {
                $data['user_image'] = UserMedia::where('mediatype', '=', 1)->where('user_id', '=', $data['user']->user_id)->count();

                $data['user_video'] = UserMedia::where('mediatype', '=', 2)->where('user_id', '=', $data['user']->user_id)->with('medialikes')->with('mediacomments')->latest()->get();

            }else if($userid == $currentuser->user_id || $userid == null){
                $data['user_image'] = UserMedia::where('mediatype', '=', 1)->where('user_id', '=', $data['user']->user_id)->count();

                $data['user_video'] = UserMedia::where('mediatype', '=', 2)->where('user_id', '=', $data['user']->user_id)->with('medialikes')->with('mediacomments')->latest()->get();

            }else{

                $data['user_image'] = UserMedia::where('mediatype', '=', 1)->where('user_id', '=', $data['user']->user_id)->where('showto',0)->count();

                $data['user_video'] = UserMedia::where('mediatype', '=', 2)->where('user_id', '=', $data['user']->user_id)->where('showto',0)->with('medialikes')->with('mediacomments')->latest()->get();
            }



            $uservideoArr = $data['user_video']->pluck('media_id')->toArray();


            $usermediaview = UserMediaView::where('user_id', '=', $currentuser->user_id)->where('media_id',$mediaid)->first();

            if (empty($usermediaview)) {
                $user_media_view               = new UserMediaView();
                $user_media_view->media_id     = $mediaid;
                $user_media_view->user_id      = $currentuser->user_id;
                $user_media_view->save();
            }
            $data['usermediaview'] = $usermediaview = UserMediaView::where('media_id',$mediaid)->count();

            $nextId = null;
            $prevId = null;
            $key = array_search($mediaid, $uservideoArr);

            if( ($key-1) < 0 ) {
                $prevId = $uservideoArr[count($uservideoArr) - 1];
            }
            else {
                $prevId = $uservideoArr[$key-1];
            }

            if( ($key+1) > (count($uservideoArr) - 1) ) {
                $nextId = $uservideoArr[0];
            }
            else {
                $nextId = $uservideoArr[$key+1];
            }

            $data['prevId'] = $prevId;
            $data['nextId'] = $nextId;

            $data['media_comment'] = MediaComment::where('media_id', '=', $mediaid)->count();

            $usermedialikes = UserMediaLike::where('media_id', '=', $mediaid)->get();
            $usermedialikesArr = $usermedialikes->pluck('user_id')->toArray();
            $data['user_video_like'] = $usermedialikes->count();

            $isVideoLiked = false;
            if(!empty($usermedialikesArr)) {
                if(in_array($this->globaldata['user']->user_id, $usermedialikesArr)) {
                    $isVideoLiked = true;
                }
            }

            $data['isVideoLiked'] = $isVideoLiked;

            $data['seosetting'] = SeoSetting::where('page', 'video-detail')->first();

            return view_front('profile/video-detail', $data);
        }
        else {
            abort(404);
        }

    }

    public function videodetailsubmit(Request $request)
    {
        if ($request->ajax()) {
            $rules = array(
                'video_caption'  => 'required'
            );
            $messages = [
                'video_caption.required' => 'Please add Video Caption.'
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
                $media_id = $request->media_id;
                $user_media = UserMedia::find($media_id);
                $user_media->caption = $request->video_caption;
                $result = $user_media->update();

                if ($result) {
                    $data["type"] = "success";
                } else {
                    $data["type"] = "error";
                }
                return response()->json($data);
            }
        } else {
            return 'No direct access allowed!';
        }
    }

    public function settings()
    {
        $data['seosetting'] = SeoSetting::where('page', 'settings')->first();
        return view_front('profile/settings', $data);
    }

    public function uservideo($userid = null)
    {
        $data   = [];
        $currentuser = $this->globaldata['user'];
        if (empty($userid)) {
            $data['user'] = $currentuser;
        } else {
            $data['user'] = User::findOrFail($userid);
        }

        $friend = Friend::where('status', 1)
                ->where('user_id', $currentuser->user_id)
                ->where('to_user_id', $userid)
                ->orwhere(function($query) use($currentuser, $userid) {
                    $query->where('user_id', $userid)->where('to_user_id', $currentuser->user_id)->where('status', 1);
                })->first();
        if ($friend) {
            $user_media = UserMedia::where('mediatype', '=', 2)->where('user_id', '=', $data['user']['user_id'])->latest()->get();

            $user_image = UserMedia::where('mediatype', '=', 1)->where('user_id', '=', $data['user']['user_id'])->count();

        }else if($userid == $currentuser->user_id || $userid == null){
            $user_media = UserMedia::where('mediatype', '=', 2)->where('user_id', '=', $data['user']['user_id'])->latest()->get();

            $user_image = UserMedia::where('mediatype', '=', 1)->where('user_id', '=', $data['user']['user_id'])->count();

        }else{

            $user_media = UserMedia::where('mediatype', '=', 2)->where('user_id', '=', $data['user']['user_id'])->where('showto',0)->latest()->get();

            $user_image = UserMedia::where('mediatype', '=', 1)->where('user_id', '=', $data['user']['user_id'])->where('showto',0)->count();
        }

        $data['user_media'] = $user_media;
        $data['user_image'] = $user_image;

        $data['seosetting'] = SeoSetting::where('page', 'user-videos')->first();


        return view_front('profile/user-video', $data);
    }


    public function loaderuservideo(Request $request, $userid) {
        // if ajax request
        if ($request->ajax()) {

            $data   = [];

            $currentuser = $this->globaldata['user'];
            if (empty($userid)) {
                $user = $currentuser;
            } else {
                $user = User::findOrFail($userid);
            }

            $friend = Friend::where('status', 1)
                                ->where('user_id', $currentuser->user_id)
                                ->where('to_user_id', $userid)
                                ->orwhere(function($query) use($currentuser, $userid) {
                                    $query->where('user_id', $userid)->where('to_user_id', $currentuser->user_id)->where('status', 1);
                                })->first();

            if ($friend) {
                $user_media = UserMedia::where('mediatype', '=', 2)->where('user_id', '=', $user->user_id)->latest();
            }
            else if($userid == $currentuser->user_id || $userid == null){
                $user_media = UserMedia::where('mediatype', '=', 2)->where('user_id', '=', $user->user_id)->latest();
            }
            else{
                $user_media = UserMedia::where('mediatype', '=', 2)->where('user_id', '=', $user->user_id)->where('showto',0)->latest();
            }


            $itemcount = $user_media->get()->count();
            $data['user_media'] = $user_media->paginate(config('constants.perpage'));


            $htmldata = view_front('ajax.user-video', $data)->render();

            return response()->json(['htmldata' => $htmldata, 'itemcount' => $itemcount]);
        }
        // if non ajax request
        else {
            return 'No direct access allowed!';
        }
    }


    public function settingsubmit(Request $request)
    {

        if ($request->ajax()) {
            $request->validate([
                // 'email' => 'required|email|exists:users',
                'password' => 'required|confirmed',
                'password_confirmation' => 'required'
            ]);
            $user_id = $this->globaldata['user']->user_id;
            $user = User::find($user_id);

            if (!Hash::check($request->password, $user->password)) {
                $user->email = $request->email;
                $user->password = Hash::make($request->password);
                $user->update();

                $data['type'] = 'success';
                $data['caption'] = 'Password reset successfully.';
            } else {
                $data['type'] = 'error';
                $data['caption'] = 'You can not use your current password as a new password.';
            }
            return response()->json($data);
        } else {
            return 'No direct access allowed!';
        }
    }

    public function notifications()
    {
        $user = $this->globaldata['user'];

        $notification = NotificationSetting::where('user_id', $user->user_id)->first();

        if(empty($notification)) {
            $notificarion_setting           = new NotificationSetting();
            $notificarion_setting->user_id  = $user->user_id;
            $notificarion_setting->save();

            $data['notification']= $notificarion_setting;
        }else{
            $data['notification']= $notification;
        }

        $data['seosetting'] = SeoSetting::where('page', 'notification')->first();
        return view_front('profile/notifications',$data);
    }

    public function notificationsubmit(Request $request){
        if ($request->ajax()) {
            $user = $this->globaldata['user'];
            $notification = NotificationSetting::where('user_id', $user->user_id)->first();

            $notificarion_setting = NotificationSetting::findOrFail($notification->notification_setting_id);
            $notificarion_setting->inbox_message = intval($request->inbox_message);
            $notificarion_setting->friend_request = intval($request->friend_request);
            $notificarion_setting->follow_me = intval($request->follow_me);
            $notificarion_setting->like_image = intval($request->like_image);
            $notificarion_setting->like_video = intval($request->like_video);
            $notificarion_setting->like_topic = intval($request->like_topic);
            $notificarion_setting->like_comment = intval($request->like_comment);
            $notificarion_setting->mention_member = intval($request->mention_member);
            $notificarion_setting->comment_image = intval($request->comment_image);
            $notificarion_setting->comment_video = intval($request->comment_video);
            $notificarion_setting->comment_topic = intval($request->comment_topic);
            $notificarion_setting->replay_comment = intval($request->replay_comment);
            $result = $notificarion_setting->update();

            if ($result) {
                $data["type"] = "success";
            } else {
                $data["type"] = "error";
            }
            return response()->json($data);

        }else{
            return 'No direct access allowed!';
        }

    }


    public function mediacomment(Request $request) {
        // if ajax request
        if ($request->ajax()) {

            $rules = array(
                'media_comment'              => 'required',
            );

            $messages = [
                'media_comment.required' => 'Please enter comment.',
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
                $media_id = intval($request->media_id);
                $mediatype = intval($request->mediatype);
                $media_comment = trim($request->media_comment);
                $user = $this->globaldata['user'];

                $mediacomment           = new MediaComment();
                $mediacomment->media_id = $media_id;
                $mediacomment->user_id  = $user->user_id;
                $mediacomment->type     = $mediatype;
                $mediacomment->comment  = $media_comment;

                $result = $mediacomment->save();

                $user_media_comment = UserMedia::where('media_id', '=', $media_id)->first();
                if ($user->user_id != $user_media_comment->user_id) {

                    $from_user = User::where('user_id', $user_media_comment->user_id)->first();
                    $user_profile = url('/profile/'.$user->user_id);
                    $notification_setting = NotificationSetting::where('user_id', $user_media_comment->user_id)->first();

                    if ($user_media_comment->mediatype == 2) {
                        $current_url = url('/video-detail/'.$media_id);
                        userNotification($user->user_id,$user_media_comment->user_id, 'videocomment' ,$current_url,'',$media_comment);

                        $subject = $user->username.' commented on your video.';

                        if ($notification_setting->comment_video == 1) {
                            if(!empty($from_user)) {
                                $api_response = SendgridTrait::sendEmail([
                                    //SET SENDGRID EMAIL TEMPLATE ID
                                    'templateid'  => 'd-f67ee96bf6214dbd85cf145d9fc71cee',
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

                    if ($user_media_comment->mediatype == 1) {

                        $current_url = url('/image-detail/'.$media_id);
                        userNotification($user->user_id,$user_media_comment->user_id, 'imagecomment' ,$current_url,$user_media_comment->smallthumbfile,$media_comment);
                        $subject = $user->username.' commented on your image.';

                        if ($notification_setting->comment_video == 1) {
                            if(!empty($from_user)) {
                                $api_response = SendgridTrait::sendEmail([
                                    //SET SENDGRID EMAIL TEMPLATE ID
                                    'templateid'  => 'd-f526712129314e0db967e24818e162cb',
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

                if($result) {
                    $data['comment'] = view_front('ajax.media-comment', ['mediacomment' => $mediacomment])->render();
                    $data['media_comment'] = MediaComment::where('media_id', '=', $media_id)->count();
                    $data['media_id'] = $media_id;
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

    public function mediarplcomment(Request $request) {
        // if ajax request
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
                $media_id           = intval($request->media_id);
                $media_comment_id   = intval($request->media_comment_id);
                $reply_comment      = trim($request->reply_comment);
                $user               = $this->globaldata['user'];
                $mediatype          = intval($request->mediatype);

                $mediarplcomment               = new MediaComment();
                $mediarplcomment->media_id     = $media_id;
                $mediarplcomment->user_id      = $user->user_id;
                $mediarplcomment->parent_id    = $media_comment_id;
                $mediarplcomment->type         = $mediatype;
                $mediarplcomment->comment      = $reply_comment;

                $result = $mediarplcomment->save();

                $user_media_rel_comment = UserMedia::where('media_id', '=', $media_id)->first();
                $media_comment = MediaComment::where('media_comment_id', '=', $media_comment_id)->where('media_id', '=', $media_id)->first();
                if ($user->user_id != $media_comment->user_id ) {

                    $media_comment = MediaComment::where('media_comment_id', '=', $media_comment_id)->where('media_id', '=', $media_id)->first();

                    if ($user->user_id != $media_comment->user_id) {

                        $from_user = User::where('user_id', $media_comment->user_id)->first();
                        $user_profile = url('/profile/'.$user->user_id);
                        $notification_setting = NotificationSetting::where('user_id', $media_comment->user_id)->first();

                        if ($user_media_rel_comment->mediatype == 1) {

                            $current_url = url('/image-detail/'.$media_id.'/'.$user_media_rel_comment->user_id);

                            userNotification($user->user_id,$media_comment->user_id, 'imagerplcomment' ,$current_url,$user_media_rel_comment->smallthumbfile,$reply_comment);

                            $subject = $user->username.' replied your image comment.';


                            if ($notification_setting->replay_comment == 1) {
                                if(!empty($from_user)) {
                                    $api_response = SendgridTrait::sendEmail([
                                        //SET SENDGRID EMAIL TEMPLATE ID
                                        'templateid'  => 'd-b63a6c1b27d74e6a895a1aff5eb895c3',
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

                        if ($user_media_rel_comment->mediatype == 2) {

                            $current_url = url('/video-detail/'.$media_id.'/'.$user_media_rel_comment->user_id);

                            userNotification($user->user_id,$media_comment->user_id, 'videorplcomment' ,$current_url,'',$reply_comment);

                            $subject = $user->username.' replied your video comment.';

                            if ($notification_setting->replay_comment == 1) {
                                if(!empty($from_user)) {
                                    $api_response = SendgridTrait::sendEmail([
                                        //SET SENDGRID EMAIL TEMPLATE ID
                                        'templateid'  => 'd-c9ea5546f3754aa0b361c8ed60ea394e',
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

                if($result) {
                    $data['comment'] = view_front('ajax.media-comment-rpl', ['mediarplcomment' => $mediarplcomment])->render();
                    $data['media_comment'] = MediaComment::where('media_id', '=', $media_id)->count();
                    $data['media_id'] = $media_id;
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

    public function mediadeletecomment(Request $request)
    {
        // dd($request);
        // if ajax request
        if ($request->ajax()) {

            $media_comment_id = intval($request->media_comment_id);
            $media_id = intval($request->media_id);
            $user_id = $this->globaldata['user']->user_id;

            $mediacomment = MediaComment::where('media_comment_id', $media_comment_id)->where('media_id', $media_id)->first();

            if ($user_id == $mediacomment->user_id || $this->globaldata['user']->issuperadmin == 1) {

                MediaComment::where('parent_id', $mediacomment->media_comment_id)->delete();

                $result = $mediacomment->delete();
                $data['media_comment'] = MediaComment::where('media_id', '=', $media_id)->count();
                $data['type'] = 'success';
                $data['media_comment_id'] = $media_comment_id;
                $data['caption'] = 'Comment deleted successfully.';
            } else {
                $data['type'] = 'error';
                $data['caption'] = 'You are not authorized to delete comment.';
            }

            return response()->json($data);
        } else {
            return 'No direct access allowed!';
        }
    }

    public function mediarpldeletecomment(Request $request)
    {
        // dd($request);
        // if ajax request
        if ($request->ajax()) {

            $media_comment_id = intval($request->media_comment_id);
            $media_id = intval($request->media_id);
            $user_id = $this->globaldata['user']->user_id;

            $mediacomment = MediaComment::where('media_comment_id', $media_comment_id)->where('media_id', $media_id)->first();

            if ($user_id == $mediacomment->user_id || $this->globaldata['user']->issuperadmin == 1) {

                $result = $mediacomment->delete();
                $data['media_comment'] = MediaComment::where('media_id', '=', $media_id)->count();
                $data['type'] = 'success';
                $data['media_comment_id'] = $media_comment_id;
                $data['caption'] = 'Comment deleted successfully.';
            } else {
                $data['type'] = 'error';
                $data['caption'] = 'You are not authorized to delete comment.';
            }

            return response()->json($data);
        } else {
            return 'No direct access allowed!';
        }
    }

    public function deleteAccount(Request $request)
    {
        // if ajax request
        if ($request->ajax()) {

            $user_id = intval($request->user_id);
            $user = User::find($user_id);
            if ($user) {
                $comments = Comment::where('user_id', $user_id)->get();
                if (!$comments->isEmpty()) {
                    foreach ($comments as  $comment) {
                        if (!empty($comment->media)) {
                            $path =  deleteS3Media($comment->media->path);
                            $comment->media->delete();
                        }
                        $comment->delete();
                    }
                }

                $media_comments = MediaComment::where('user_id', $user_id)->get();
                if (!$media_comments->isEmpty()) {
                    foreach ($media_comments as  $media_comment) {
                        $media_comment->delete();
                    }
                }

                $posts = Post::where('user_id', $user_id)->get();
                if (!$posts->isEmpty()) {
                    foreach ($posts as  $post) {


                        if (!empty($post->comments)) {
                            foreach ($post->comments as  $comments) {
                                $comments->delete();
                            }
                        }

                        if (!empty($post->media)) {
                                deleteS3Media($post->media->path);
                                $post->media->delete();
                        }
                        $post->delete();
                    }
                }

                $usertoken = Usertoken::where('user_id', $user_id)->delete();

                $user_media_likes = UserMediaLike::where('user_id', $user_id)->get();
                if (!$user_media_likes->isEmpty()) {
                    foreach ($user_media_likes as  $user_media_like) {
                        $user_media_like->delete();
                    }
                }

                $conversations = Conversation::where('to_id', $user_id)->orwhere('from_id', $user_id)->get();
                if (!$conversations->isEmpty()) {
                    foreach ($conversations as  $conversation) {
                        if (!$conversation->conversationmessages->isEmpty()) {

                            foreach ($conversation->conversationmessages as  $conversationmessages) {
                                if (!empty($conversationmessages->imagefile)) {
                                    deleteS3Media($conversationmessages->imagefile);
                                }
                                if (!empty($conversationmessages->thumbfile)) {
                                    deleteS3Media($conversationmessages->thumbfile) ;
                                }
                                $conversationmessages->delete();
                            }
                        }
                        $conversation->delete();
                    }
                }

                $user_medias = UserMedia::where('user_id', $user_id)->get();
                if (!$user_medias->isEmpty()) {
                    foreach ($user_medias as $user_media) {

                        if (!empty($user_media->mediafile)) {
                            $mediafile =  deleteS3Media($user_media->mediafile);
                        }

                        if (!empty($user_media->smallthumbfile)) {
                            $smallthumbfile = deleteS3Media($user_media->smallthumbfile);
                        }

                        if (!empty($user_media->mediumthumbfile)) {
                            $mediumthumbfile =  deleteS3Media($user_media->mediumthumbfile);
                        }

                        if (!empty($user_media->largethumbfile)) {
                            $largethumbfile =  deleteS3Media($user_media->largethumbfile);
                        }

                        if (!empty($user_media->videothumbfile)) {
                            $videothumbfile = deleteS3Media($user_media->videothumbfile);
                        }
                        $user_media->delete();
                    }


                }

                $group_duscussion_comments = GroupDiscussionComment::where('user_id', $user_id)->get();
                if (!empty($group_duscussion_comments) ) {
                    foreach ($group_duscussion_comments as  $group_duscussion_comment) {
                        if ($group_duscussion_comment->imagefile) {
                            deleteS3Media($group_duscussion_comment->imagefile);
                        }
                        if ($group_duscussion_comment) {
                            deleteS3Media($group_duscussion_comment->thumbimagefile);
                        }
                        $group_duscussion_comment->delete();
                    }
                }

                $group_duscussion_likes = GroupDiscussionLike::where('user_id', $user_id)->get();
                if (!empty($group_duscussion_likes)) {
                    foreach ($group_duscussion_likes as  $group_duscussion_like) {
                        $group_duscussion_like->delete();
                    }
                }

                $group_duscussion_views = GroupDiscussionView::where('user_id', $user_id)->get();
                if (!empty($group_duscussion_views)) {
                    foreach ($group_duscussion_views as  $group_duscussion_views) {
                        $group_duscussion_views->delete();
                    }
                }

                $group_duscussions = GroupDiscussion::where('user_id', $user_id)->get();
                if (!empty($group_duscussions)) {
                    foreach ($group_duscussions as  $group_duscussion) {

                        if ($group_duscussion->imagefile) {
                            deleteS3Media($group_duscussion->imagefile);
                        }
                        if ($group_duscussion->thumbimagefile) {
                            deleteS3Media($group_duscussion->thumbimagefile);
                        }
                        $group_duscussion->delete();
                    }
                }

                $group_members = GroupMember::where('user_id', $user_id)->get();
                if (!empty($group_members)) {
                    foreach ($group_members as  $group_member) {
                        $group_member->delete();
                    }
                }

                $groups = Group::where('user_id', $user_id)->get();
                if (!$groups->isEmpty()) {
                    foreach ($groups as  $group) {
                        $group->delete();
                    }
                }

                if (!empty($user)) {
                    if (!empty($user->imagefile)) {
                        $imagefile =  deleteS3Media($user->imagefile);
                    }

                    if (!empty($user->smallthumbfile)) {
                        $smallthumbfile = deleteS3Media($user->smallthumbfile);
                    }

                    if (!empty($user->mediumthumbfile)) {
                        $mediumthumbfile = deleteS3Media($user->mediumthumbfile);
                    }

                    if (!empty($user->largethumbfile)) {
                        $largethumbfile = deleteS3Media($user->largethumbfile);
                    }
                    $user->delete();
                }
                if($user_id == $this->globaldata['user']->user_id) {
                    Auth::guard()->logout();
                    $data['redirectUrl'] = url('/');
                }
                else {
                    $data['redirectUrl'] = url('/profile');
                }

                // $result = $user->delete();

                $data['type'] = 'success';

                $data['caption'] = 'Account deleted successfully.';
            } else {
                $data['type'] = 'error';
                $data['caption'] = 'Unable to delete account.';
            }

            return response()->json($data);
        } else {
            return 'No direct access allowed!';
        }
    }
    public function blockUser(Request $request)
    {
        if ($request->ajax()) {

            $currentuser = $this->globaldata['user'];
            $to_user_id = intval($request->to_user_id);

            $blockuser = BlockUser::where('to_user_id', $to_user_id)->first();
            if ($blockuser) {
                $blockuser->delete();

                $friend = Friend::where('status', 2)
                ->where('user_id', $currentuser->user_id)
                ->where('to_user_id', $to_user_id)
                ->orwhere(function($query) use($currentuser, $to_user_id) {
                    $query->where('user_id', $to_user_id)->where('to_user_id', $currentuser->user_id)->where('status', 2);
                })->first();
                if (!empty($friend)) {
                    $friend->status = 1;
                    $friend->update();
                }

                $data['type'] = 'success';
                $data['caption'] = 'Successfully unblock User.';
                $data['flag'] = 'unblocked';

            }else{
                $block_user                  = new BlockUser();
                $block_user->user_id         = $currentuser->user_id;
                $block_user->to_user_id      = $to_user_id;
                $result = $block_user->save();

                $friend = Friend::where('status', 1)
                ->where('user_id', $currentuser->user_id)
                ->where('to_user_id', $to_user_id)
                ->orwhere(function($query) use($currentuser, $to_user_id) {
                    $query->where('user_id', $to_user_id)->where('to_user_id', $currentuser->user_id)->where('status', 1);
                })->first();
                if (!empty($friend)) {
                    $friend->status = 2;
                    $friend->update();
                }

                if($result) {
                    $data['type'] = 'success';
                    $data['caption'] = 'Successfully block User.';
                    $data['flag'] = 'blocked';
                }else {
                    $data['type'] = 'error';
                    $data['caption'] = 'unable to block user. Please try again later!';
                }

            }
            return response()->json($data);
        }else{
            return 'No direct access allowed!';
        }
    }
    public function follow(Request $request) {
        // dd($request);
        // if ajax request
        if ($request->ajax()) {

            $to_user_id = intval($request->to_user_id);

            $user = $this->globaldata['user'];
            $user_id = $user->user_id;

            $follow = new Follow();
            $follow->user_id    = $user_id;
            $follow->to_user_id = $to_user_id;
            $result = $follow->save();

            if ($user_id != $to_user_id) {
                userNotification($user_id,$to_user_id, 'follow' ,'','','');

                $from_user = User::where('user_id', $to_user_id)->first();
                $notification_setting = NotificationSetting::where('user_id', $to_user_id)->first();

                if ($notification_setting->follow_me == 1) {
                    if(!empty($from_user)) {
                        $api_response = SendgridTrait::sendEmail([
                            //SET SENDGRID EMAIL TEMPLATE ID
                            'templateid'  => 'd-d575f09ea02d4c6989a490e2612be5ef',
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
                                'subject'           => $user->username.' followed you',
                                'confirmation_link' => '',
                                'name'              =>  $from_user->username,
                                'from_user'         =>  $user->username,
                                'support_mail'      =>  config('constants.adminemail')
                            ]
                        ]);
                    }
                }
            }

            if($result) {
                $data['type'] = 'success';
                $data['caption'] = 'following';
            }
            else {
                $data['type'] = 'error';
                $data['caption'] = 'Unable to following';
            }
            return response()->json($data);
        } else {
            return 'No direct access allowed!';
        }
    }

    public function unfollow(Request $request) {
        // dd($request);
        // if ajax request
        if ($request->ajax()) {

            $to_user_id = intval($request->to_user_id);

            $user = $this->globaldata['user'];
            $user_id = $user->user_id;

            $follow = Follow::where('user_id', $user_id)->where('to_user_id', $to_user_id)->first();

            if($follow) {
                $result = $follow->delete();

                if($result) {
                    $data['type'] = 'success';
                    $data['caption'] = 'Unfollowed.';
                }
                else {
                    $data['type'] = 'error';
                    $data['caption'] = 'Unable to unfollow.';
                }
            }
            else {
                $data['type'] = 'error';
                $data['caption'] = 'Unable to process your request. Please try again later!';
            }

            return response()->json($data);
        } else {
            return 'No direct access allowed!';
        }
    }
}
