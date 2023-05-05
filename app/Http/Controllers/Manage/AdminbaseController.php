<?php namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use View;
use App\Models\User;


class AdminbaseController extends Controller {

	protected $globaldata = [];

    public function __construct() {

        // $this->middleware('adminauth');

    	if(Auth::guard('admin')->check()) {
    		$admin = Auth::guard('admin')->user();
    		$this->globaldata['admin'] = $admin;

    		View::share('globaldata', $this->globaldata);
    	}
        elseif(Auth::guard('client')->check()) {
            $admin = Auth::guard('client')->user();
            $this->globaldata['admin'] = $admin;

            View::share('globaldata', $this->globaldata);
        }
        elseif(Auth::guard('member')->check()) {
            $admin = Auth::guard('member')->user();
            $this->globaldata['admin'] = $admin;

            View::share('globaldata', $this->globaldata);
        }
    }

    public function isSuperAdmin() {
        if($this->globaldata['admin']->issuperadmin == 1) {
            return true;
        }
        else {
            return false;
        }
    }
}
