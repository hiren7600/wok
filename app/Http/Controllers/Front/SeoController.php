<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Front\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\SeoSetting;
use App\Models\State;

class SeoController extends BaseController
{
    public function index() {
        $data = [];

        $page = config('constants.page');
        $data['page'] = $page;
        $data['states'] = State::where('countryid', 231)->get()->pluck('statename', 'statename')->toArray();

        return view_front('seo', $data);
    }

    public function submit(Request $request) {
        if ($request->ajax()) {
            // dd($request->all());
            $rules = array(
                'page'              => 'required',
                'meta_title'        => 'required',
                'meta_keyword'      => 'required',
                'meta_description'  => 'required'
            );

            $messages = [
                'page.required'             => 'Please select page.',
                'meta_title.required'       => 'Please enter meta title.',
                'meta_keyword.required'     => 'Please enter meta keyword.',
                'meta_description.required' => 'Please enter meta description.'
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
                $page               = trim($request->page);
                $meta_title         = trim($request->meta_title);
                $meta_keyword       = trim($request->meta_keyword);
                $meta_description   = trim($request->meta_description);
                $meta_robot         = trim($request->meta_robot);
                $state              = trim($request->state);

                if(empty($state)) {
                    $seosetting = SeoSetting::where('page', $page)->where('state', null)->first();
                }
                else {
                    $seosetting = SeoSetting::where('page', $page)->where('state', $state)->first();   
                }

                if(empty($seosetting)) {
                    $seosetting                     = new SeoSetting();
                    $seosetting->page               = $page;
                    $seosetting->meta_title         = $meta_title;
                    $seosetting->meta_keyword       = $meta_keyword;
                    $seosetting->meta_description   = $meta_description;
                    $seosetting->meta_robot         = $meta_robot;
                    $seosetting->state              = $state;
                    $result                         = $seosetting->save();
                    $captionsuccess = 'Seo saved successfully.';
                    $captionerror = 'Unable to save seo.';
                }
                else {
                    $seosetting->page               = $page;
                    $seosetting->meta_title         = $meta_title;
                    $seosetting->meta_keyword       = $meta_keyword;
                    $seosetting->meta_description   = $meta_description;
                    $seosetting->meta_robot         = $meta_robot;
                    $seosetting->state              = $state;
                    $result                         = $seosetting->update();   
                    $captionsuccess = 'Seo updated successfully.';
                    $captionerror = 'Unable to update seo.';
                }

                if ($result) {
                    $data["type"]       = "success";
                    $data["caption"]    = $captionsuccess;
                } else {
                    $data["type"] = "error";
                    $data["caption"] = $captionerror;
                }
            }

            return response()->json($data);
        } else {
            return 'No direct access allowed!';
        }
    }

    public function getpage(Request $request) {
        if ($request->ajax()) {

            $rules = array(
                'page'              => 'required',
            );

            $messages = [
                'page.required'             => 'Please select page.',
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
                $page = trim($request->page);
                $state = trim($request->state);

                if(empty($state)) {
                    $seosetting = SeoSetting::where('page', $page)->where('state', null)->first();
                }
                else {
                    $seosetting = SeoSetting::where('page', $page)->where('state', $state)->first();   
                }

                $data['type'] = 'success';
                if(!empty($seosetting)) {
                    $data['seo'] = $seosetting->toArray();
                }
                else {
                    $data['seo'] = [];
                }

            }

            return response()->json($data);
        } else {
            return 'No direct access allowed!';
        }
    }
}
