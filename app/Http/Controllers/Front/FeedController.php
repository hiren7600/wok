<?php

namespace App\Http\Controllers\Front;

set_time_limit(0);

use App\Http\Controllers\Front\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Post;
use App\Models\Postmedia;
use App\Models\Comment;
use App\Models\UserMedia;
use App\Models\Friend;
use App\Models\Follow;
use App\Models\State;
use App\Models\City;
use App\Models\SeoSetting;

class FeedController extends BaseController
{

    public function index()
    {

        $data   = [];
        $user = $this->globaldata['user'];

        $friends = Friend::where('status', 1)->where('to_user_id', $user->user_id)->orWhere('user_id', $user->user_id)->where('status', 1)->get()->toArray();
        $friendcounts = count($friends);

        $friendArr = [];
        foreach($friends as $friend) {
            if(!in_array($friend['user_id'], $friendArr)) {
                array_push($friendArr, $friend['user_id']);
            }

            if(!in_array($friend['to_user_id'], $friendArr)) {
                array_push($friendArr, $friend['to_user_id']);
            }
        }

        $followings = Follow::where('user_id', $user->user_id)->get()->toArray();
        foreach($followings as $following) {
            if(!in_array($following['to_user_id'], $friendArr)) {
                array_push($friendArr, $following['to_user_id']);
            }
        }

        if(!in_array($this->globaldata['user']->user_id, $friendArr)) {
            array_push($friendArr, $this->globaldata['user']->user_id);
        }

        $posts = Post::whereIn('user_id', $friendArr)->orderBy('latest_updated_at', 'desc')->latest();

        $postcount = $posts->get()->count();
        $data['posts'] = $posts->get()->take(config('constants.perpage'));
        
        $useraddress = $this->globaldata['user']->address;
        $data['state'] = State::where('statename',trim(explode(',',$useraddress)[1]))->with('cities')->first();
        $data['city'] = City::where('cityname', trim(explode(',',$useraddress)[0]))->first();

        
        $data['friendcounts'] = $friendcounts;
        $data['seosetting'] = SeoSetting::where('page', 'feed')->first();
        return view_front('feed', $data);
    }


    public function load(Request $request) {
        // if ajax request
        if ($request->ajax()) {

            $data   = [];
            $user = $this->globaldata['user'];

            $friends = Friend::where('status', 1)->where('to_user_id', $user->user_id)->orWhere('user_id', $user->user_id)->where('status', 1)->get()->toArray();
            $friendcounts = count($friends);
            $friendArr = [];
            foreach($friends as $friend) {
                if(!in_array($friend['user_id'], $friendArr)) {
                    array_push($friendArr, $friend['user_id']);
                }

                if(!in_array($friend['to_user_id'], $friendArr)) {
                    array_push($friendArr, $friend['to_user_id']);
                }
            }

            $followings = Follow::where('user_id', $user->user_id)->get()->toArray();
            foreach($followings as $following) {
                if(!in_array($following['to_user_id'], $friendArr)) {
                    array_push($friendArr, $following['to_user_id']);
                }
            }

            if(!in_array($this->globaldata['user']->user_id, $friendArr)) {
                array_push($friendArr, $this->globaldata['user']->user_id);
            }

            $posts = Post::whereIn('user_id', $friendArr)->orderBy('latest_updated_at', 'desc')->latest();

            $postcount = $posts->get()->count();
            $data['posts'] = $posts->paginate(config('constants.perpage'));


            // $projects = Project::latest('project_id')->paginate(config('constants.perpage'));
            // $data['projects'] = $projects;
            $htmldata = view_front('ajax.feed-list', $data)->render();

            return response()->json(['htmldata' => $htmldata, 'postcount' => $postcount]);
        }
        // if non ajax request
        else {
            return 'No direct access allowed!';
        }
    }

    public function submit(Request $request)
    {
        // dd($request);
        // if ajax request
        if ($request->ajax()) {
            $user_id = $this->globaldata['user']->user_id;
            $rules = [];
            $messages = [];

            if (!$request->hasFile('feedmedia')) {
                $rules['content'] = 'required';
                $messages['content.required'] = 'Please enter feed.';
            }

            if ($request->hasFile('feedmedia')) {
                $rules['feedmedia'] = 'mimes:jpg,JPG,jpeg,JPEG,png,PNG';
                $messages['feedmedia.mimes'] = 'Please select vaild image file.';
            }
            // if ($request->hasFile('feedmedia')) {
            //     $rules['feedmedia'] = 'mimes:jpg,jpeg,png,gif,m4v,mov,mp4,wmv,flv';
            //     $messages['feedmedia.mimes'] = 'Please select vaild image or video file.';
            // }

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

                $post = new Post();
                $post->type = 1;
                $post->user_id = $user_id;
                $post->content = trim($request->content);
                $post->status = 1;
                $result = $post->save();

                if ($result) {

                    // upload image file if exist
                    if ($request->hasFile('feedmedia')) {
                        $mediafile = $request->file('feedmedia');
                        $extension = $mediafile->getClientOriginalExtension();

                        $validImageTypes = ['gif', 'jpeg', 'JPEG', 'jpg', 'JPG', 'png', 'PNG'];
                        $validVideoTypes = ['m4v', 'mov', 'mp4', 'wmv', 'flv'];
                        $media_type = 0;
                        if (in_array($extension, $validImageTypes)) {
                            $media_type = 0;
                        } elseif (in_array($extension, $validVideoTypes)) {
                            $media_type = 1;
                        }

                        $imageName = time() . '.' . $extension;
                        if ($media_type == 0) {

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
                            } elseif ($extension == 'png') {
                                $bck   = imagecolorallocate($image, 0, 0, 0);
                                imagecolortransparent($image, $bck);
                                imagealphablending($image, false);
                                imagesavealpha($image, true);
                                $imgobject = imagepng($image, null, 5);
                            }
                            $image_contents = ob_get_clean();

                            // $img = Image::make($mediafile);
                            // $img->fit(1280, 720, function ($constraint) {
                            //     $constraint->upsize();
                            // })->encode($extension);

                            $imagePath = 'feeds/' . $post->post_id . '/' . $imageName;

                            $path = Storage::disk('s3')->put($imagePath, $image_contents);
                            $amazonImgFeedUrl = Storage::disk('s3')->url($imagePath);
                        } else {
                            $path = Storage::disk('s3')->put('feeds/' . $post->post_id, $mediafile);
                            $amazonImgFeedUrl = Storage::disk('s3')->url($path);
                        }

                        //Thumb large image
                        $imgThumblargeFeed = Image::make($image_contents);
                        $imgThumblargeFeed->fit(config('constants.user_large_thumb_image_width'), config('constants.user_large_thumb_image_height'), function ($constraint) {
                            $constraint->aspectRatio();
                        })->encode($extension);

                        $imageLargePathThumbFeed = 'feeds/' . $post->post_id . '/thumb/large/' . $imageName;

                        $largeThumbPathFeed = Storage::disk('s3')->put($imageLargePathThumbFeed, $imgThumblargeFeed);
                        $amazonImgUrlLargeThumbFeed = Storage::disk('s3')->url($imageLargePathThumbFeed);



                        if ($extension == 'jpeg' || $extension == 'JPEG' || $extension == 'jpg' || $extension == 'JPG') {
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

                        $imageSmallPathThumb = 'users/'.$user_id.'/thumb/small/'.$imageName;

                        $smallThumbPath = Storage::disk('s3')->put($imageSmallPathThumb, $imgThumbsmall);
                        $amazonImgUrlSmallThumb = Storage::disk('s3')->url($imageSmallPathThumb);


                        //Thumb medium image
                        $imgThumbmedium = Image::make($image_contents);
                        $imgThumbmedium->fit(config('constants.user_medium_thumb_image_width'), config('constants.user_medium_thumb_image_height'), function ($constraint) {
                            $constraint->aspectRatio();
                        })->encode($extension);

                        $imageMediumPathThumb = 'users/'.$user_id.'/thumb/medium/'.$imageName;

                        $mediumThumbPath = Storage::disk('s3')->put($imageMediumPathThumb, $imgThumbmedium);
                        $amazonImgUrlMediumThumb = Storage::disk('s3')->url($imageMediumPathThumb);


                        //Thumb large image
                        $imgThumblarge = Image::make($image_contents);
                        $imgThumblarge->fit(config('constants.user_large_thumb_image_width'), config('constants.user_large_thumb_image_height'), function ($constraint) {
                            $constraint->aspectRatio();
                        })->encode($extension);

                        $imageLargePathThumb = 'users/'.$user_id.'/thumb/large/'.$imageName;

                        $largeThumbPath = Storage::disk('s3')->put($imageLargePathThumb, $imgThumblarge);
                        $amazonImgUrlLargeThumb = Storage::disk('s3')->url($imageLargePathThumb);
                    /******************* Thumb Image ******************/

                        $postmedia                  = new Postmedia();
                        $postmedia->post_id         = $post->post_id;
                        $postmedia->path            = $amazonImgFeedUrl;
                        $postmedia->largethumbfile  = $amazonImgUrlLargeThumbFeed;
                        $postmedia->extension       = $extension;
                        $postmedia->media_type      = $media_type;
                        $postmedia->type            = 0;
                        $postmedia->save();

                        $user_media = new UserMedia();
                        $user_media->user_id            = $user_id;
                        $user_media->mediafile          = $amazonImgUrl;
                        $user_media->smallthumbfile     = $amazonImgUrlSmallThumb;
                        $user_media->mediumthumbfile    = $amazonImgUrlMediumThumb;
                        $user_media->largethumbfile     = $amazonImgUrlLargeThumb;
                        $user_media->mediatype          = 1;
                        $user_media->save();

                    }

                    $data['feed_item'] = view_front('ajax.feed', ['post' => $post])->render();

                    $data['type'] = 'success';
                    $data['caption'] = 'Feed posted.';
                } else {
                    $data['type'] = 'error';
                    $data['caption'] = 'unable to post feed. Please try again later!';
                }
            }
            return response()->json($data);
        } else {
            return 'No direct access allowed!';
        }
    }

    public function submitComment(Request $request)
    {
        // dd($request);
        // if ajax request
        if ($request->ajax()) {
            $user_id = $this->globaldata['user']->user_id;
            $comment = new Comment();
            $comment->post_id = intval($request->post_id);
            $comment->user_id = $user_id;
            $comment->comment = trim($request->feed_comment);
            $result = $comment->save();

            if ($result) {

                $postupdate = Post::find(intval($request->post_id));
                if($postupdate){
                    $postupdate->latest_updated_at = $comment->created_at;
                    $postupdate->update();
                }
                // upload image file if exist
                if ($request->hasFile('commentmedia')) {
                    $commentmedia = $request->file('commentmedia');
                    $extension = $commentmedia->getClientOriginalExtension();

                    $validImageTypes = ['gif', 'jpeg', 'JPEG', 'jpg', 'JPG', 'png', 'PNG'];
                    $validVideoTypes = ['m4v', 'mov', 'mp4', 'wmv', 'flv'];
                    $media_type = 0;
                    if (in_array($extension, $validImageTypes)) {
                        $media_type = 0;
                    } elseif (in_array($extension, $validVideoTypes)) {
                        $media_type = 1;
                    }

                    $imageName = time() . '.' . $extension;
                    if ($media_type == 0) {

                        if ($extension == 'jpeg' || $extension == 'JPEG' || $extension == 'jpg' || $extension == 'JPG') {
                            $image = imagecreatefromjpeg($commentmedia);
                        } elseif ($extension == 'png' || $extension == 'PNG') {
                            $image = imagecreatefrompng($commentmedia);
                        }

                        $exif = @exif_read_data($commentmedia);
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
                            $bck   = imagecolorallocate($image, 0, 0, 0);
                            imagecolortransparent($image, $bck);
                            imagealphablending($image, false);
                            imagesavealpha($image, true);
                            $imgobject = imagepng($image, null, 5);
                        }

                        $image_contents = ob_get_clean();

                        // $img = Image::make($commentmedia);
                        // $img->fit(1280, 720, function ($constraint) {
                        //     $constraint->upsize();
                        // })->encode($extension);

                        $imagePath = 'feeds/' . $comment->post_id . '/' . $comment->comment_id . '/' . $imageName;

                        $path = Storage::disk('s3')->put($imagePath, $image_contents);
                        $amazonImgUrl = Storage::disk('s3')->url($imagePath);
                    } else {
                        $path = Storage::disk('s3')->put('feeds/' . $comment->post_id . '/' . $comment->comment_id, $commentmedia);
                        $amazonImgUrl = Storage::disk('s3')->url($path);
                    }

                    if ($extension == 'jpeg' || $extension == 'JPEG' || $extension == 'jpg' || $extension == 'JPG') {
                        $image = imagecreatefromjpeg($commentmedia);
                    } elseif ($extension == 'png' || $extension == 'PNG') {
                        $image = imagecreatefrompng($commentmedia);
                    }

                    $exif = @exif_read_data($commentmedia);
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

                    $imageSmallPathThumb = 'users/'.$user_id.'/thumb/small/'.$imageName;

                    $smallThumbPath = Storage::disk('s3')->put($imageSmallPathThumb, $imgThumbsmall);
                    $amazonImgUrlSmallThumb = Storage::disk('s3')->url($imageSmallPathThumb);


                    //Thumb medium image
                    $imgThumbmedium = Image::make($image_contents);
                    $imgThumbmedium->fit(config('constants.user_medium_thumb_image_width'), config('constants.user_medium_thumb_image_height'), function ($constraint) {
                        $constraint->aspectRatio();
                    })->encode($extension);

                    $imageMediumPathThumb = 'users/'.$user_id.'/thumb/medium/'.$imageName;

                    $mediumThumbPath = Storage::disk('s3')->put($imageMediumPathThumb, $imgThumbmedium);
                    $amazonImgUrlMediumThumb = Storage::disk('s3')->url($imageMediumPathThumb);


                    //Thumb large image
                    $imgThumblarge = Image::make($image_contents);
                    $imgThumblarge->fit(config('constants.user_large_thumb_image_width'), config('constants.user_large_thumb_image_height'), function ($constraint) {
                        $constraint->aspectRatio();
                    })->encode($extension);

                    $imageLargePathThumb = 'users/'.$user_id.'/thumb/large/'.$imageName;

                    $largeThumbPath = Storage::disk('s3')->put($imageLargePathThumb, $imgThumblarge);
                    $amazonImgUrlLargeThumb = Storage::disk('s3')->url($imageLargePathThumb);
                /******************* Thumb Image ******************/

                    $postmedia                  = new Postmedia();
                    $postmedia->post_id         = $comment->post_id;
                    $postmedia->comment_id      = $comment->comment_id;
                    $postmedia->path            = $amazonImgUrl;
                    $postmedia->largethumbfile  = $amazonImgUrlLargeThumb;
                    $postmedia->extension       = $extension;
                    $postmedia->media_type      = $media_type;
                    $postmedia->type            = 1;
                    $postmedia->save();

                    $user_media = new UserMedia();
                    $user_media->user_id            = $user_id;
                    $user_media->mediafile          = $amazonImgUrl;
                    $user_media->smallthumbfile     = $amazonImgUrlSmallThumb;
                    $user_media->mediumthumbfile    = $amazonImgUrlMediumThumb;
                    $user_media->largethumbfile     = $amazonImgUrlLargeThumb;
                    $user_media->mediatype          = 1;
                    $user_media->save();

                }


                $data['comment'] = view_front('ajax.feed-comment', ['comment' => $comment])->render();

                $data['type'] = 'success';
                $data['caption'] = 'Comment posted.';
            } else {
                $data['type'] = 'error';
                $data['caption'] = 'unable to comment feed. Please try again later!';
            }

            return response()->json($data);
        } else {
            return 'No direct access allowed!';
        }
    }

    public function deleteComment(Request $request)
    {
        if ($request->ajax()) {

            $post_id = intval($request->post_id);
            $comment_id = intval($request->comment_id);
            $user_id = $this->globaldata['user']->user_id;

            $comment = Comment::where('comment_id', $comment_id)->where('post_id', $post_id)->first();

            if ($user_id == $comment->user_id || $this->globaldata['user']->issuperadmin == 1) {
                if (!empty($comment->media)) {
                    deleteS3Media($comment->media->largethumbfile);
                    deleteS3Media($comment->media->path);
                    $comment->media->delete();
                }
                $result = $comment->delete();

                $data['type'] = 'success';
                $data['comment_id'] = $comment_id;
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

    public function deleteFeed(Request $request)
    {
        // dd($request);
        // if ajax request
        if ($request->ajax()) {

            $post_id = intval($request->post_id);
            $user_id = $this->globaldata['user']->user_id;
            $post = Post::where('post_id', $post_id)->first();

            if ($user_id == $post->user_id || $this->globaldata['user']->issuperadmin == 1) {
                if (!empty($post->media)) {
                    deleteS3Media($post->media->largethumbfile);
                    deleteS3Media($post->media->path);

                    $post->media->delete();
                }
                if (!$post->comments->isEmpty()) {
                    $post->comments()->delete();
                }
                $result = $post->delete();

                $data['type'] = 'success';
                $data['post_id'] = $post_id;
                $data['caption'] = 'Post deleted successfully.';
            } else {
                $data['type'] = 'error';
                $data['caption'] = 'You are not authorized to delete post.';
            }

            return response()->json($data);
        } else {
            return 'No direct access allowed!';
        }
    }
}
