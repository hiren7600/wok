<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Front\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\ConversationMessage;
use App\Models\NotificationSetting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Traits\SendgridTrait;
use App\Models\SeoSetting;

class ConversationController extends BaseController
{
    public function index()
    {
        $user = $this->globaldata['user'];

        $conversations = Conversation::where('to_id',$user->user_id)
                                        ->orwhere(function($query) use($user) {
                                            $query->where('is_replied', 1)->where('from_id',$user->user_id);
                                        })->latest()->get();
        $data['user'] = $user;
        $data['conversations'] = $conversations;

        $data['seosetting'] = SeoSetting::where('page', 'conversation')->first();


        return view_front('conversation/index', $data);

    }

    public function conversationsent()
    {
        $user = $this->globaldata['user'];
        $conversations = Conversation::where('from_id',$user->user_id)->latest()->get();
        $data['user'] = $user;
        $data['conversations'] = $conversations;
        $data['seosetting'] = SeoSetting::where('page', 'conversation')->first();

        return view_front('conversation/sent', $data);

    }

    public function conersationdetails($conversation_id){
        $user = $this->globaldata['user'];
        $conversation = Conversation::where('conversation_id',$conversation_id)->first();
        if(!empty($conversation)) {

            // $conversationmessage = ConversationMessage::where('conversation_id',$conversation->conversation_id)->where('user_id','!=' ,$user->user_id)->update(['is_read'=>1]);

            $data['conversation'] = $conversation;
            $data['seosetting'] = SeoSetting::where('page', 'conversation')->first();
            return view_front('conversation/conversation_details',$data);
        }
        else {
            abort('404');
        }

    }

    public function conversationmarkread(Request $request){
        $user = $this->globaldata['user'];
        if ($request->ajax()) {
            $conversationmessage = ConversationMessage::where('conversation_id',$request->conversation_id)->where('user_id','!=' ,$user->user_id)->update(['is_read'=>1]);

            $data['type'] = 'success';
            return response()->json($data);
        }else{
            return 'No direct access allowed!';
        }
    }

    public function submitconersationdetilas(Request $request){
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
                    $user    = $this->globaldata['user'];
                    $to_id      = intval($request->to_id);

                    $conversation_message                   = new ConversationMessage();
                    $conversation_message->conversation_id  = $request->conversation_id;
                    $conversation_message->user_id          = $user->user_id;
                    $conversation_message->message          = trim($request->message);
                    $conversation_message->is_read          = 0;
                    $result                                 = $conversation_message->save();

                    if($result){

                        $conversation = Conversation::find($request->conversation_id);
                        if($conversation->to_id ==  $user->user_id) {
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

                            $imagePath = 'conversation/' . $request->conversation_id . '/' . $imageName;

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

                            $imagePathThumb = 'conversation/' . $request->conversation_id . '/thumb/' . $imageName;

                            $path = Storage::disk('s3')->put($imagePathThumb, $thumb_image_contents);
                            $amazonImgUrlThumb = Storage::disk('s3')->url($imagePathThumb);
                            /******************* Original Image ******************/

                            $conversation_message->imagefile        = $amazonImgUrl;
                            $conversation_message->thumbfile        = $amazonImgUrlThumb;
                            $conversation_message->update();


                            $data['comment'] = view_front('ajax.conversation-message', ['conversationmessage' => $conversation_message])->render();
                            $data['type'] = 'success';

                        }  else {
                            $data["type"] = "success";
                            $data['caption'] = 'message send .';
                        }
                        $data['comment'] = view_front('ajax.conversation-message', ['conversationmessage' => $conversation_message])->render();
                        $data['type'] = 'success';
                    }else {
                        $data['type'] = 'error';
                        $data['caption'] = 'unable to send message. Please try again later!';
                    }


                    $from_user = User::where('user_id', $to_id)->first();

                    $api_response = SendgridTrait::sendEmail([
                        //SET SENDGRID EMAIL TEMPLATE ID
                        'templateid'  => 'd-fce889fdd76a4607adb9fdedfc01a438',
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
                            'subject'           => $user->username.' sent you new meessage',
                            'confirmation_link' => '',
                            'name'              =>  $from_user->username,
                            'support_mail'      =>  config('constants.adminemail')
                        ]
                    ]);
                }
            return response()->json($data);
        }else{
            return 'No direct access allowed!';
        }
    }

    public function submit(Request $request){
        if ($request->ajax()) {

            $user = $this->globaldata['user'];
            $user_id = $user->user_id;

            $conversation          = new Conversation();
            $conversation->from_id = $user_id;
            $conversation->to_id   = $request->to_id;
            $conversation->subject = $request->subject;
            $result                = $conversation->save();

            if ($result) {
                $conversation_message                   = new ConversationMessage();
                $conversation_message->conversation_id  = $conversation->conversation_id;
                $conversation_message->user_id          = $user_id;
                $conversation_message->message          = $request->message;
                $conversation_message->imagefile        = $request->imagefile;
                $conversation_message->thumbfile        = $request->thumbfile;
                $conversation_message->is_read          = 0;
                $conversation_message->save();

                $touser = User::where('user_id', $request->to_id)->first();

                $notification_setting = NotificationSetting::where('user_id', $request->to_id)->first();
                if ($notification_setting->inbox_message == 1) {
                    $current_url = url('/conversation-details/'.$conversation->conversation_id);
                    userNotification($user_id, $request->to_id, 'newmessage' ,$current_url,'','');

                    if(!empty($touser)) {
                        $conversation_link = url('conversation-details/'.$conversation->conversation_id);
                        $api_response = SendgridTrait::sendEmail([
                            //SET SENDGRID EMAIL TEMPLATE ID
                            'templateid'  => 'd-99b402777c584e9c9acf137fbea26d93',
                            //SET SUBJECT FOR WITHOUT USING TEMPLATE
                            'subject'    => '',
                            //SET BODY FOR WITHOUT USING TEMPLATE
                            'body'       => '',
                            //SET RECIVER EMAIL AND NAME
                            'to'         => [
                                // 'to_email'   => $user->email,
                                'to_email'   => $touser->email,
                                'to_name'    => $touser->username
                            ],
                            //SET SENDER EMAIL AND NAME
                            'from'      => [
                                'from_email' => '',
                                'from_name'  => ''
                            ],
                            //SET DYNAMIC DATA TO REPLACE IN EMAIL TEMPLATE
                            'data'      => [
                                //SET DYNAMIC TEMPLATE SUBJECT
                                'subject'           => 'New message received.',
                                'conversation_link' =>  $conversation_link,
                                'name'              =>  $touser->username,
                                'from_user'         =>  $user->username,
                                'support_mail'      =>  config('constants.adminemail')
                            ]
                        ]);

                        $responseCode = $api_response->statusCode();
                    }
                }

                $data['type'] = 'success';
            }  else {
                $data['type'] = 'error';
            }
            return response()->json($data);
        }else{
            return 'No direct access allowed!';
        }
    }

    public function deleteconversation(Request $request){
        if ($request->ajax()) {

            $conversation_id = $request->conversation_id;
            // $comment_id = intval($request->comment_id);
            // $user_id = $this->globaldata['user']->user_id;
            if (!empty($conversation_id)) {

            $conversation = Conversation::where('conversation_id', $conversation_id)->first();

            $result = ConversationMessage::where('conversation_id', $conversation_id)->delete();
              if ($result) {
                $conversation->delete();
              }
                $data['type'] = 'success';
                $data['caption'] = 'conversation deleted successfully.';
            } else {
                $data['type'] = 'error';
                $data['caption'] = 'You are not authorized to delete conversation.';
            }

            return response()->json($data);
        } else {
            return 'No direct access allowed!';
        }
    }

    public function emailsent()
    {
        $data['seosetting'] = SeoSetting::where('page', 'conversation')->first();
        return view_front('conversation/sent');
    }
    public function emailarchived()
    {
        $data['seosetting'] = SeoSetting::where('page', 'conversation')->first();
        return view_front('conversation/archived');
    }
}
