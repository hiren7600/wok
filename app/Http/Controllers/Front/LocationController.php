<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Front\BaseController;
use App\Models\City;
use Illuminate\Http\Request;
use App\Models\State;
use App\Models\Country;
use App\Models\User;
use App\Models\AdCategory;
use App\Models\AdPost;
use App\Models\AdPostMedia;
use App\Models\Conversation;
use App\Models\ConversationMessage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use App\Models\SeoSetting;

class LocationController extends BaseController
{

    public function index($statename = null, $cityname = null )
    {
        $useraddress = $this->globaldata['user']->address;


        if (!empty($_GET['country'])) {

            $county_name = $_GET['country'];

            $users = User::where('address', 'LIKE', '%'.$county_name.'%')->orderBy('smallthumbfile', 'desc')->latest();
            $data['userscount'] = $users->get()->count();
            $data['users'] = $users->limit(10)->get();
            // dd($data);


            $ad_categories = AdCategory::withcount(['adposts as adcount' => function($q) use ($county_name) {
                return $q->where('ad_posts.location', 'LIKE', "%$county_name%");
            }])->get();

            // dd($ad_categories->sum('adcount'));
            $data['ad_categories'] = $ad_categories;

            if(!empty($category)) {
                $adposts = AdPost::where('location', 'LIKE', '%'.$county_name.'%')->where('ad_category_id', $category->ad_category_id)->latest()->get();
            }
            else {
                $adposts = AdPost::where('location', 'LIKE', '%'.$county_name.'%')->latest()->get();
            }

            $data['adposts'] = $adposts->groupBy(function($item) {
                return $item->created_at->format('Y-m-d');
            });

            $data['adpostcount'] = $adposts->count();

            $data['seosetting'] = SeoSetting::where('page', 'location')->where('state', null)->first();

        }else{
            if (!empty($statename)) {
                $state = State::where('statename',$statename )->with('cities')->first();
            }
            else {
                $state = State::where('statename',trim(explode(',',$useraddress)[1]))->with('cities')->first();
            }
            if (empty($cityname)) {
                $city = City::where('cityname', trim(explode(',',$useraddress)[0]))->first();
            }
            else {
                $city = City::where('cityname', $cityname)->first();
            }

            if (!empty($statename) && empty($cityname)) {
                $city_name = $statename;
            }
            else {
                if (empty($city)) {
                    $city_name = $statename;
                }else{
                    $city_name = $city->cityname;
                }
            }

            $data['state'] = $state;

            $data['city_name'] = $city_name;

            $category = null;
            if(isset($_GET['category']) && !empty($_GET['category'])) {
                $categoryslug = trim($_GET['category']);
                $category = AdCategory::where('slug', $categoryslug)->first();
            }

            $users = User::where('address', 'LIKE', '%'.$city_name.'%')->orderBy('smallthumbfile', 'desc')->latest();
            $data['userscount'] = $users->get()->count();
            $data['users'] = $users->limit(10)->get();
            // $data['adposts'] = AdPost::where('location', 'LIKE', '%'.$city_name.'%')->latest()->get();

            // $ad_categories = AdCategory::withcount('adcount')->get();


            $ad_categories = AdCategory::withcount(['adposts as adcount' => function($q) use ($city_name) {
                return $q->where('ad_posts.location', 'LIKE', "%$city_name%");
            }])->get();

            // dd($ad_categories->sum('adcount'));
            $data['ad_categories'] = $ad_categories;

            if(!empty($category)) {
                $adposts = AdPost::where('location', 'LIKE', '%'.$city_name.'%')->where('ad_category_id', $category->ad_category_id)->latest()->get();
            }
            else {
                $adposts = AdPost::where('location', 'LIKE', '%'.$city_name.'%')->latest()->get();
            }

            $data['adposts'] = $adposts->groupBy(function($item) {
                return $item->created_at->format('Y-m-d');
            });

            $data['adpostcount'] = $adposts->count();

            // $data['adposts'] = AdPost::where('location', 'LIKE', '%'.$city_name.'%')->latest()->get()->groupBy(function($item) {
            //     return $item->created_at->format('Y-m-d');
            // });

            $data['seosetting'] = SeoSetting::where('page', 'location')->where('state', null)->first();
        }



        return view_front('location/index',$data);
    }
    public function member($statename = null, $city_name = null )
    {
        $useraddress = $this->globaldata['user']->address;

        if (!empty($_GET['country'])) {
            $country_name = $_GET['country'];
            $data['users'] = User::where('address', 'LIKE', '%'.$country_name.'%')->orderBy('smallthumbfile', 'desc')->latest()->get();

            $data['seosetting'] = SeoSetting::where('page', 'location')->where('state', null)->first();
        }else{
            if (!empty($statename)) {
                $data['state'] = State::where('statename',$statename )->with('cities')->first();
            }else{
                $data['state'] = State::where('statename',trim(explode(',',$useraddress)[1]))->with('cities')->first();
            }
            if (empty($city_name)) {

                if (!empty($statename)) {
                    $city_name = $data['state']->statename;
                }else{
                    $city_name = trim(explode(',',$useraddress)[1]);
                }
                $data['city_name'] = $city_name;
            }else{
                // $city = City::where('cityid', $city_name)->first();
                // $city_name = $city_name;
                $data['city_name'] = $city_name;
            }
            $data['users'] = User::where('address', 'LIKE', '%'.$city_name.'%')->orderBy('smallthumbfile', 'desc')->latest()->get();

            $data['seosetting'] = SeoSetting::where('page', 'location')->where('state', null)->first();
        }


        return view_front('location/member',$data);
    }

    public function chnagelocation()
    {
        $data['united_states'] = Country::where('countryid', 231)->with('states')->first();
        $data['seosetting'] = SeoSetting::where('page', 'location')->where('state', null)->first();
        return view_front('location/county_list',$data);
    }

    public function selectcity($statename = null)
    {
        if(!empty($statename)) {
            $state = State::where('statename', $statename)->first();
        }
        else {
            $useraddress = $this->globaldata['user']->address;
            $state = State::where('statename',trim(explode(',',$useraddress)[1]))->first();
            $statename = $state->statename;
        }
        $data['state'] = $state;

        $data['cities'] = City::where('stateid', $data['state']->stateid)->get();
        $totalmembers = $data['cities']->sum('membercount');

        $data['memberflag1'] = $totalmembers/3;
        $data['memberflag2'] = $totalmembers/4;

        // $data['cities'] = City::where('stateid', $data['state']->stateid)->get()->pluck('membercount', 'cityname')->toArray();
        // dd($data['cities']);

        $data['statename'] = $statename;
        $data['seosetting'] = SeoSetting::where('page', 'location')->where('state', $statename)->first();
        return view_front('location/city_list',$data);
    }

     public function postadcategory() {

        $data['ad_categories'] = AdCategory::all();
        $data['seosetting'] = SeoSetting::where('page', 'location')->where('state', null)->first();
        return view_front('location/postad-category', $data);
    }

    public function createad($category) {
        $data   = [];
        $user = $this->globaldata['user'];

        $adcategory = AdCategory::where('slug', $category)->first();
        if(!empty($adcategory)) {
            $data['adcategory'] = $adcategory;
            $data['seosetting'] = SeoSetting::where('page', 'location')->where('state', null)->first();
            return view_front('location/create-add', $data);

        }
        else {
            return abort('404');
        }
    }
    public function createadsubmit(Request $request) {
        // dd($request->all());

        if ($request->ajax()) {

            $rules = array(
                'title'         => 'required',
                'location'      => 'required',
                'content'       => 'required',
                'tnc'           => 'required'
            );

            if ($request->hasFile('imagefile')) {
                $rules['imagefile[]'] = 'mimes:jpg,JPG,jpeg,JPEG,png,PNG,gif,GIF';
            }

            $messages = [
                'imagefile.required'    => 'Please select image.',
                'imagefile.mimes'       => 'Please select jpg, jpeg, png or gif file.',
                'title.required'        => 'Please enter title.',
                'location.required'     => 'Please select location.',
                'content.required'      => 'Please enter post content.',
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

                $user = $this->globaldata['user'];
                $user_id = $user->user_id;

                $slug   =  Str::slug(trim($request->title), "-");

                $slug   = $this->checkSlug($slug);

                $adpost = new AdPost();
                $adpost->ad_category_id = $request->ad_category_id;
                $adpost->user_id        = $user_id;
                $adpost->title          = $request->title;
                $adpost->slug           = $slug;
                $adpost->location       = $request->location;
                $adpost->content        = $request->content;
                $result = $adpost->save();

                $captionsuccess = 'Ad created successfully.';
                $captionerror = 'Unable create ad. Please try again.';

                if($result) {

                    if ($request->hasFile('imagefile')) {
                        $imagefiles   = $request->file('imagefile');
                        foreach ($imagefiles as $imagefile) {

                            // $imagefile   = $request->file('imagefile');
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

                                $imagePath = 'ad/' . $adpost->ad_post_id . '/' . $imageName;

                                $path = Storage::disk('s3')->put($imagePath, $image_contents);
                                $amazonImgUrl = Storage::disk('s3')->url($imagePath);
                            /******************* Original Image ******************/

                            /******************* Thumb Image ******************/
                                //Thumb large image
                                $imgThumblarge = Image::make($image_contents);
                                $imgThumblarge->fit(config('constants.user_large_thumb_image_width'), config('constants.user_large_thumb_image_height'), function ($constraint) {
                                    $constraint->aspectRatio();
                                })->encode($extension);

                                $imageLargePathThumb = 'ad/'.$adpost->ad_post_id.'/thumb/'.$imageName;

                                $largeThumbPath = Storage::disk('s3')->put($imageLargePathThumb, $imgThumblarge);
                                $amazonImgUrlLargeThumb = Storage::disk('s3')->url($imageLargePathThumb);
                            /******************* Thumb Image ******************/

                            $adpostmedia = new AdPostMedia();
                            $adpostmedia->ad_post_id = $adpost->ad_post_id;
                            $adpostmedia->thumbfile = $amazonImgUrlLargeThumb;
                            $adpostmedia->imagefile = $amazonImgUrl;
                            $adpostmedia->save();
                        }

                    }

                    $data["type"] = "success";
                    $data["redirectUrl"] = url('/location');
                    $data["caption"] = $captionsuccess;

                }
                else {
                    $data["type"] = "error";
                    $data["caption"] = $captionerror;
                }

            }
            return response()->json($data);
        } else {
            return 'No direct access allowed!';
        }

    }

    public function casualencounter($state_id = null, $city_id = null ) {

        $useraddress = $this->globaldata['user']->address;

        if (!empty($state_id)) {
            $state = State::where('stateid',$state_id )->with('cities')->first();
        }
        else {
            $state = State::where('statename',trim(explode(',',$useraddress)[1]))->with('cities')->first();
        }

        if (empty($city_id)) {
            $city = City::where('cityname', trim(explode(',',$useraddress)[0]))->first();
        }
        else {
            $city = City::where('cityid', $city_id)->first();
        }

        $data['state'] = $state;
        $city_name = $city->cityname;
        $data['city_name'] = $city_name;


        $data['users'] = User::where('address', 'LIKE', '%'.$city_name.'%')->orderBy('smallthumbfile', 'desc')->latest()->get();

        $data['seosetting'] = SeoSetting::where('page', 'location')->where('state', null)->first();

        return view_front('location/casual-encounter',$data);
    }

    public function viewad($slug) {
        $adpost = AdPost::where('slug',$slug)->first();
        if (empty($adpost)) {
            $adpost = AdPost::find($slug);
        }

        if (!empty($adpost)) {
            $data['adpost'] = $adpost;
            $data['city'] = trim(explode(',',$adpost->location)[0]);
            $data['state'] = trim(explode(',',$adpost->location)[1]);

            $adposts = AdPost::where('location', 'LIKE', '%'.$data['city'].'%')->latest()->get();
            $adpostArr = [];
            foreach($adposts as $key => $adpost) {
                if(!empty($adpost->slug)) {
                    $adpostArr[$key] = $adpost->slug;
                }
                else {
                    $adpostArr[$key] = $adpost->ad_post_id;
                }
            }
            $nextId = null;
            $prevId = null;
            $key = array_search($slug, $adpostArr);

            if( ($key-1) < 0 ) {
                $prevId = $adpostArr[count($adpostArr) - 1];
            }
            else {
                $prevId = $adpostArr[$key-1];
            }

            if( ($key+1) > (count($adpostArr) - 1) ) {
                $nextId = $adpostArr[0];
            }
            else {
                $nextId = $adpostArr[$key+1];
            }


            $data['prevId'] = $prevId;
            $data['nextId'] = $nextId;

            $data['seosetting'] = SeoSetting::where('page', 'location')->where('state', null)->first();

            return view_front('location/ad-post-view',$data);
        }
        else {
            return abort('404');
        }

    }

    public function contactadpost(Request $request) {
        // dd($request);
        if ($request->ajax()) {

            $rules = [];
            $messages = [];

            if (!$request->hasFile('imagefile')) {
                $rules['message'] = 'required';
                $messages['message.required'] = 'Please enter feed.';
            }

            if ($request->hasFile('imagefile')) {
                $rules['imagefile'] = 'mimes:jpg,JPG,jpeg,JPEG,png,PNG';
                $messages['imagefile.mimes'] = 'Please select vaild image file.';
            }

            $validator  = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                $data['type'] = 'error';
                $data['caption'] = 'One or more invalid input found.';
                $data['errorfields'] = $validator->errors()->keys();
                $data['errormessage'] = $validator->errors()->all();
            }else {
                    $user_id    = $this->globaldata['user']->user_id;
                    $to_id      = intval($request->to_id);

                    $conversation          = new Conversation();
                    $conversation->from_id = $user_id;
                    $conversation->to_id   = $to_id;
                    $conversation->subject = $request->subject;
                    $result                = $conversation->save();

                    if($result) {

                        $conversation_message                   = new ConversationMessage();
                        $conversation_message->conversation_id  = $conversation->conversation_id;
                        $conversation_message->user_id          = $user_id;
                        $conversation_message->message          = trim($request->message);
                        $conversation_message->is_read          = 0;
                        $result                                 = $conversation_message->save();

                        if($result){

                            if($conversation->to_id ==  $user_id) {
                                $conversation->is_replied = 1;
                                $conversation->update();
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

                                $imagePath = 'conversation/' . $conversation->conversation_id . '/' . $imageName;

                                $path = Storage::disk('s3')->put($imagePath, $image_contents);
                                $amazonImgUrl = Storage::disk('s3')->url($imagePath);
                                /******************* Original Image ******************/

                                /******************* Thumb Image ******************/
                                if ($extension == 'jpeg' || $extension == 'JPEG' || $extension == 'jpg' || $extension == 'JPG') {
                                    $thumbImage = imagecreatefromjpeg($imagefile);
                                } elseif ($extension == 'png' || $extension == 'PNG') {
                                    $thumbImage = imagecreatefrompng($imagefile);
                                }

                                $exif = @exif_read_data($imagefile);
                                if (!empty($exif['Orientation'])) {
                                    if ($exif['Orientation'] == 8) {
                                        $thumbImage = imagerotate($thumbImage, 90, 0);
                                    } else if ($exif['Orientation'] == 3) {
                                        $thumbImage = imagerotate($thumbImage, 180, 0);
                                    } else if ($exif['Orientation'] == 6) {
                                        $thumbImage = imagerotate($thumbImage, -90, 0);
                                    }
                                }

                                ob_start();
                                if ($extension == 'jpeg' || $extension == 'JPEG' || $extension == 'jpg' || $extension == 'JPG') {
                                    $thumbImage = imagescale($thumbImage, 100, 100);
                                    $thumbimgobject = imagejpeg($thumbImage, null, 50);
                                } elseif ($extension == 'png' || $extension == 'PNG') {
                                    $thumbImage = imagescale($thumbImage, 100, 100);
                                    $bck = imagecolorallocate($thumbImage, 0, 0, 0);
                                    imagecolortransparent($thumbImage, $bck);
                                    imagealphablending($thumbImage, false);
                                    imagesavealpha($thumbImage, true);
                                    $thumbimgobject = imagepng($thumbImage, null, 5);
                                }

                                $thumb_image_contents = ob_get_clean();

                                $imagePathThumb = 'conversation/' . $conversation->conversation_id . '/thumb/' . $imageName;

                                $path = Storage::disk('s3')->put($imagePathThumb, $thumb_image_contents);
                                $amazonImgUrlThumb = Storage::disk('s3')->url($imagePathThumb);
                                /******************* Original Image ******************/

                                $conversation_message->imagefile        = $amazonImgUrl;
                                $conversation_message->thumbfile        = $amazonImgUrlThumb;
                                $conversation_message->update();

                            }

                            $data["type"] = "success";
                            $data['caption'] = 'message send.';

                        }else {
                            $data['type'] = 'error';
                            $data['caption'] = 'unable to contact user. Please try again later!';
                        }
                    }
                    else {
                        $data['type'] = 'error';
                        $data['caption'] = 'unable to contact user. Please try again later!';
                    }
                }
            return response()->json($data);
        }else{
            return 'No direct access allowed!';
        }
    }

    public function deletead(Request $request) {
        // dd($request);
        if ($request->ajax()) {


            $user_id    = $this->globaldata['user']->user_id;
            $ad_post_id      = intval($request->ad_post_id);

            $ad_post = AdPost::where('ad_post_id', $ad_post_id)->first();


            if($ad_post) {

                $adpostmedias = $ad_post->admedias;
                if(!$adpostmedias->isEmpty()) {
                    foreach($adpostmedias as $adpostmedia) {

                        deleteS3Media($adpostmedia->thumbfile);
                        deleteS3Media($adpostmedia->imagefile);

                        $adpostmedia->delete();
                    }
                }
                $result = $ad_post->delete();

                if($result) {
                    $data["type"] = "success";
                    $data['redirectUrl'] = url('/location');
                    $data['caption'] = 'Ad deleted.';
                }
                else {
                    $data["type"] = "error";
                    $data['caption'] = 'Unable to delete ad. Please try again later!';
                }

            }
            else {
                $data['type'] = 'error';
                $data['caption'] = 'Unable to delete ad. Please try again later!';
            }

            return response()->json($data);
        }else{
            return 'No direct access allowed!';
        }
    }

    // Check slug and retun unique slug
    public function checkSlug($slug) {
       $res = AdPost::where('slug', $slug)->latest()->get();
       if(!$res->isEmpty()) {
            $slug_array = explode('-', $slug);
            $last = (int) $slug_array[count($slug_array) - 1];
            if($last > 0) {
                array_pop($slug_array);
                $count = $last;
            }
            else {
                $count = 0;
            }
            $count++;
            $new_slug = implode('-', $slug_array).'-'.$count;
            return $this->checkSlug($new_slug);
       }
        else {
            return $slug;
        }
    }
}
