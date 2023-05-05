<?php namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Manage\AdminbaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
Use Carbon\Carbon;
use App\Models\User;
use App\Models\Designation;


class UserController extends AdminbaseController {

	/* admin list page */
    public function index() {
    	$data = ['menu_users' => true];

        return view_admin('users.users', $data);
    }


    /* admin list data through ajax  */
    public function load(Request $request) {
    	// if ajax request
    	if ($request->ajax()) {

    		$users = User::members()->notsuperadmin()->search($request->search)->latest('user_id')->paginate(config('constants.perpage'));
			$data['users'] = $users;
    		return view_admin('ajax.users.users', $data);

    	}
		// if non ajax request
		else {
			return 'No direct access allowed!';
		}
    }

    /* user add page */
    public function create() {
        $data = ['menu_users' => true];
        $user = new User();
        $data['user'] = $user;
        $data['designations'] = Designation::active()->pluck('name', 'designation_id')->toArray();

        return view_admin('users.user', $data);
    }


    /* user edit page */
    public function edit($id) {

    	$user = User::members()->notsuperadmin()->find($id);
    	if(!empty($user)) {
    		$data = ['menu_users' => true];
            $data['user'] = $user;
    		$data['designations'] = Designation::active()->pluck('name', 'designation_id')->toArray();

            return view_admin('users.user', $data);
    	}
    	else {
    		return abort('404');
    	}

    }


    /* user add / update code */
    public function store(Request $request) {
    	// if ajax request
    	if ($request->ajax()) {
            // dd($request);
    		$data = [];

    		$user_id = intval($request->user_id);
    		$email  = trim($request->email);

    		// make validation rules for received data
    		$rules = [
    				'firstname'	    => 'required',
                    'lastname'      => 'required',
    				'email'         => 'required|email',
                    'phoneno'       => 'required|numeric'
    		];

            if($request->imagefile != "") {
                $rules['imagefile'] = 'mimes:jpeg,jpg,png';
            }

    		if($user_id == 0) {
    			$rules['password'] = 'required|confirmed';
    		}
            else {
    			$rules['password'] = 'confirmed';
    		}

            $user = ($user_id == 0) ? new User() : User::members()->notsuperadmin()->find($user_id);

    		// validate received data
    		$validator = Validator::make($request->all(), $rules);

    		$validator->after(function($validator) use ($user_id, $email) {
    			// check provided email availability
    			$res = User::where('user_id', '!=', $user_id)->where('email', $email)->get();
    			if(count($res) > 0) {
    				$validator->errors()->add('email', 'Email is already in use. Please try different email.');
    			}
    		});

    		// if validation fails
    		if ($validator->fails()) {
    			$data['type'] = 'error';
    			$data['caption'] = 'One or more invalid input found.';
    			$data['errorfields'] = $validator->errors()->keys();
    			$data['errormessage'] = $validator->errors()->all();
    		}
    		// if validation success
    		else {

                $user->firstname        = $request->firstname;
                $user->lastname         = $request->lastname;
                $user->email            = $request->email;
                $user->phoneno          = $request->phoneno;
                $user->usertype         = 2;
                $user->designation_id   = intval($request->designation_id);
                $user->issuperadmin     = 0;
                $user->status           = intval($request->status);

    			if($request->password != '') {
    				$password = $request->password;
    				$user->password = Hash::make($password);
    			}

                // add
                if($user_id == 0) {

                    $result = $user->save();
                    $captionsuccess = 'User added successfully.';
                    $captionerror = 'Unable add user. Please try again.';

    			}
    			// edit
    			else {
    				$result = $user->update();
    				$captionsuccess = 'User updated successfully.';
    				$captionerror = 'Unable update user. Please try again.';
    			}


    			// database insert/update success
    			if($result) {

    				$data["type"] = "error";

	                $imgpath = public_path($user->userdir);

	                // delete image if set to true
	                if(intval($request->deleteimage) == 1) {

                        // delete old image file if any
                        if($user->hasimage) {
                            File::deleteDirectory($imgpath);
                        }

                        $user->imagefile = '';
                        $user->update();
	                }

					// upload image file if exist
	                if ($request->hasFile('imagefile')) {
                        if($request->file('imagefile')->isValid()) {
                            $imagefile   = $request->file('imagefile');
		                    $extension = $request->file('imagefile')->getClientOriginalExtension();
		                    // delete old image file
		                    File::deleteDirectory($imgpath);
		                    $img = Image::make($imagefile);
		                    $img->fit(config('constants.user_image_width'), config('constants.user_image_height'), function ($constraint) {
		                    	$constraint->upsize();
		                    });
		                    $filecreated = File::makeDirectory($imgpath, 0777, true, true);
		                    if($filecreated) {
		                    	$fileName = getTempName($imgpath, $extension);
		                    	if($img->save($imgpath . $fileName)) {
			                        $user->imagefile = $fileName;
			                        $user->update();
			                        $data["type"] = "success";
			                    }
                                else {
			                        $data['caption'] = $captionsuccess. ' But unable to upload user image.';
			                    }
		                    }
                            else {
		                    	$data['caption'] = $captionsuccess. ' But unable to upload user image.';
		                    }
	                    }
                        else {
	                    	$data['caption'] = $captionsuccess. ' But invalid file uploaded.';
	                    }
	                }
	                // if no image uploaded
	                else {
	                	$data["type"] = "success";
	                }


    				if($data["type"] == 'success') {
    					$data['caption'] = $captionsuccess;
    					$data['redirectUrl'] = url('/manage/users');
    				}
    			}
    			// database insert/update fail
    			else {
    				$data['type'] = 'error';
    				$data['caption'] = $captionerror;
    			}
    		}


    		return response()->json($data);

    	}
    	// if non ajax request
    	else {
    		return 'No direct access allowed!';
    	}
    }


    /* user delete */
    public function destroy(Request $request) {
        // if ajax request
        if ($request->ajax()) {

            $data = [];

            $user = User::members()->notsuperadmin()->find($request->user_id);
            if(!empty($user)) {

                $userdir = public_path($user->userdir);
                $files_deleted = true;

                // delete old image file if any
                if($user->hasimage) {
                    if(!File::deleteDirectory($userdir)) {
                        $files_deleted = false;
                    }
                }

                // if physical files deleted then delete entry from database
                if($files_deleted) {
                    if($user->delete()) {
                        $data['type'] = 'success';
                        $data['caption'] = 'User deleted successfully.';
                    }
                    else {
                        $data['type'] = 'error';
                        $data['caption'] = 'Unable to delete user.';
                    }
                }
                // physical files not deleted
                else {
                    $data['type'] = 'error';
                    $data['caption'] = 'Unable to delete user.';
                }
            }
            else {
                $data['type'] = 'error';
                $data['caption'] = 'Invalid user.';
            }

            return response()->json($data);
        }
        // if non ajax request
        else {
            return 'No direct access allowed!';
        }
    }


}
?>
