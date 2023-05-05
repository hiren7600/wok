<?php namespace App\Http\Controllers\Manage;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Manage\AdminbaseController;

class LogoutController extends AdminbaseController {

	public function logout(){
		if(isset(Auth::guard('admin')->user()->user_id)) {
			Auth::guard('admin')->logout();
			return redirect('/login');	
		}
		else{
			Auth::guard('client')->logout();
			return redirect('/login');	
		}
	}

}

