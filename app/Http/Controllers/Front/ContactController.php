<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Front\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Traits\SendgridTrait;
use App\Models\Contact;
use App\Models\SeoSetting;

class ContactController extends BaseController
{
    public function index()
    {
        $data['seosetting'] = SeoSetting::where('page', 'contact-us')->first();
        return view_front('contact-us', $data);
    }

    public function submit(Request $request)
    {
        // if ajax request
        if ($request->ajax()) {
            $email = trim($request->email);
            $rules = array(
                'name'                  => 'required',
                'email'                 => 'required|email',
                'subject'               => 'required',
                'message'               => 'required'
            );

            $messages = [
                'name.required'         => 'Please enter name.',
                'email.required'        =>  'Please enter email address.',
                'email.email'           =>  'Please enter a valid email address.',
                'subject.required'      =>  'Please enter subject.',
                'message.required'      =>  'Please enter message.',

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
                $contact = new Contact();
                $contact->name              = $request->name;
                $contact->email             = $request->email;
                $contact->subject           = $request->subject;
                $contact->message           = $request->message;
                $contact->isread            = 0;
                $result = $contact->save();

                $captionsuccess = 'Thank you for your interest. We will get back to you soon.';
                $captionerror = 'Unable sent mail. Please try again.';

                // database insert/update success
                if ($result) {

                    $api_response = SendgridTrait::sendEmail([
                        //SET SENDGRID EMAIL TEMPLATE ID
                        'templateid'  => 'd-01b8e88b37474619bc9b7cfbca2c465d',
                        //SET SUBJECT FOR WITHOUT USING TEMPLATE
                        'subject'    => '',
                        //SET BODY FOR WITHOUT USING TEMPLATE
                        'body'       => '',
                        //SET RECIVER EMAIL AND NAME
                        'to'         => [
                            // 'to_email'   => $user->email,
                            'to_email'   => config('constants.adminetomail'),
                            'to_name'    => config('constants.adminname')
                        ],
                        //SET SENDER EMAIL AND NAME
                        'from'      => [
                            'from_email' => '',
                            'from_name'  => ''
                        ],
                        //SET DYNAMIC DATA TO REPLACE IN EMAIL TEMPLATE
                        'data'      => [
                            //SET DYNAMIC TEMPLATE SUBJECT
                            'subject'           => 'Contact Enquiry',
                            'user_name'         =>  $request->name,
                            'user_email'        =>  $request->email,
                            'contact_subject'   =>  $request->subject,
                            'message'           => $request->message
                        ]
                    ]);

                    $responseCode = $api_response->statusCode();

                    $data['type'] = 'success';
                    $data['caption'] = $captionsuccess;
                }
                // database insert/update fail
                else {
                    $data['type'] = 'error';
                    $data['caption'] = $captionerror;
                }
            }
            return response()->json($data);
        } else {
            return 'No direct access allowed!';
        }
    }
}
