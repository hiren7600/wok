<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Support\Facades\Auth;


class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

    use Authenticatable, CanResetPassword;

    protected $table        = 'users';

    protected $primaryKey   = 'user_id';

    protected $hidden       = [
        'password',
        'remember_token'
    ];

    protected $appends      = [
        'userdir',
        'imagefilepath',
        'thumbimagefilepath',
        'hasimage',
        'statustext',
        'fullname',
        'smallthumbimagefilepath',
        'mediumthumbimagefilepath',
        'largethumbimagefilepath',
    ];

    /*----------SETTER GETTER START----------*/
    public function getUserdirAttribute() {
        return config('constants.path_user') . intval($this->user_id) . '/';

    }

    public function getThumbimagefilepathAttribute() {
        $imagefile = trim($this->imagefile);
        $thumbfile = trim($this->thumbfile);

        if(!empty(trim($thumbfile))) {
            return $thumbfile;
        }
        else if(!empty(trim($imagefile))) {
            return $imagefile;
        }
        else {
            return asset('images/no-images/user.png');
        }
    }

    public function getSmallthumbimagefilepathAttribute() {
        $imagefile = trim($this->imagefile);
        $smallthumbfile = trim($this->smallthumbfile);
        $mediumthumbfile = trim($this->mediumthumbfile);
        $largethumbfile = trim($this->largethumbfile);

        if(!empty(trim($smallthumbfile))) {
            return $smallthumbfile;
        }
        else if(!empty(trim($mediumthumbfile))) {
            return $mediumthumbfile;
        }
        else if(!empty(trim($largethumbfile))) {
            return $largethumbfile;
        }
        else if(!empty(trim($imagefile))) {
            return $imagefile;
        }
        else {
            return asset('images/no-images/user.png');
        }
    }

    public function getMediumthumbimagefilepathAttribute() {
        $imagefile = trim($this->imagefile);
        $mediumthumbfile = trim($this->mediumthumbfile);
        $largethumbfile = trim($this->largethumbfile);

        if(!empty(trim($mediumthumbfile))) {
            return $mediumthumbfile;
        }
        else if(!empty(trim($largethumbfile))) {
            return $largethumbfile;
        }
        else if(!empty(trim($imagefile))) {
            return $imagefile;
        }
        else {
            return asset('images/no-images/user.png');
        }
    }

    public function getLargethumbimagefilepathAttribute() {
        $imagefile = trim($this->imagefile);
        $largethumbfile = trim($this->largethumbfile);

        if(!empty(trim($largethumbfile))) {
            return $largethumbfile;
        }
        else if(!empty(trim($imagefile))) {
            return $imagefile;
        }
        else {
            return asset('images/no-images/user.png');
        }
    }

    public function getImagefilepathAttribute() {
        $imagefile = trim($this->imagefile);

        if(!empty(trim($imagefile))) {
            return $imagefile;
        }
        else {
            return asset('images/no-images/user.png');
        }
    }

    public function getHasimageAttribute() {
        $imagefile = trim($this->imagefile);
        $user_id = intval($this->user_id);
        if(file_exists(public_path() . config('constants.path_user') . $user_id . '/' . $imagefile) && $imagefile != '') {
            return true;
        }
        return false;
    }

    public function getStatustextAttribute() {
        if($this->status == 1) {
            return '<span class="badge bg-inverse-success">Yes</span>';
        }
        else {
            return '<span class="badge bg-inverse-danger">No</span>';
        }
    }

    public function getFullnameAttribute() {
        return $this->firstname.' '.$this->lastname;
    }
    /*----------SETTER GETTER END----------*/


    /*----------RELATION FUNCTIONS START----------*/
    public function sentfriendrequest() {
        return $this->hasMany('App\Models\Friend', 'user_id');
    }

    public function following() {
        return $this->hasOne('App\Models\Follow', 'user_id');
    }

    public function receivedfriendrequest() {
        return $this->hasMany('App\Models\Friend', 'to_user_id', 'user_id');
    }

    public function userimages() {
        return $this->hasMany('App\Models\UserMedia', 'user_id')->where('mediatype', 1);
    }

    public function uservideos() {
        return $this->hasMany('App\Models\UserMedia', 'user_id')->where('mediatype', 2);
    }

    public function membergroups() {
        return $this->hasMany('App\Models\GroupMember', 'user_id');
    }

    /*----------RELATION FUNCTIONS START----------*/



    /*----------SOCPE FUNCTIONS START----------*/
    public function scopeSearch($query, $value) {
        if(!empty(trim($value))) {
            $value = trim($value);
            $query->where('users.email', 'LIKE', '%'.$value.'%')
                  ->orWhere('users.username', 'LIKE', '%'.$value.'%')
                  ->orWhere('users.sexual_orientation', 'LIKE', '%'.$value.'%')
                  ->orWhere('users.relationship_status', 'LIKE', '%'.$value.'%')
                  ->orWhere('users.address', 'LIKE', '%'.$value.'%');
        }
        return $query;
    }

    public function scopeAdminuser($query){
        return $query->Where('usertype', 1);
    }

    public function scopeUser($query){
        return $query->Where('usertype', 2);
    }

    public function scopeNotsuperadmin($query){
        return $query->where('issuperadmin', 0);
    }

    public function scopeAdmin($query) {
        return $query->where('users.usertype', 1);
    }

    public function scopeActive($query) {
        return $query->where('users.status', 1);
    }
    /*----------SOCPE FUNCTIONS END----------*/


    public function usermedia() {
        return $this->belongsTo('App\Models\UserMedia', 'media_id');
    }

}
