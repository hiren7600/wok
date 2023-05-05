<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Front\BaseController;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Libraries\Api\Frontapi\Api;
use Illuminate\Support\Facades\Auth;
use App\Models\SeoSetting;

class HomeController extends BaseController
{

    public function index()
    {
        $data = [];
        $data['seosetting'] = SeoSetting::where('page', 'home')->first();
        return view_front('home', $data);
    }

    public function footer_dmca()
    {
        $data['seosetting'] = SeoSetting::where('page', 'dmca')->first();
        return view_front('dmca', $data);
    }

    public function footer_privacy()
    {
        $data['seosetting'] = SeoSetting::where('page', 'privacy-policy')->first();
        return view_front('privacy', $data);
    }

    public function footer_service()
    {
        $data['seosetting'] = SeoSetting::where('page', 'terms')->first();
        return view_front('service', $data);
    }

    public function footer_guidelines()
    {
        $data['seosetting'] = SeoSetting::where('page', 'posting-guidelines')->first();
        return view_front('guidelines', $data);
    }

    public function footer_2257()
    {
        $data['seosetting'] = SeoSetting::where('page', '2257')->first();
        return view_front('2257', $data);
    }

    public function dashboard()
    {
        return view_front('dashboard');
    }

    
}
