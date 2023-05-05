<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class UserMedia extends Model
{
    use HasFactory;

    protected $table        = 'user_media';

    protected $primaryKey   = 'media_id';

    protected $appends      = [
        'videothumbfilepath',
        'smallthumbimagefilepath',
        'mediumthumbimagefilepath',
        'largethumbimagefilepath',
    ];

    public function comments() {
        return $this->hasMany('App\Models\MediaComment', 'media_id', 'media_id')->where('type', 0)->where('parent_id', null);
    }

    public function user() {
        return $this->belongsTo('App\Models\User', 'user_id', 'user_id');
    }
    public function videocomments() {
        return $this->hasMany('App\Models\MediaComment', 'media_id', 'media_id')->where('type', 1)->where('parent_id', null);
    }
    public function mediacomments() {
        return $this->hasMany('App\Models\MediaComment', 'media_id', 'media_id')->where('type', 1);
    }

    public function medialikes() {
        return $this->hasMany('App\Models\UserMediaLike', 'media_id');
    }

    public function getVideothumbfilepathAttribute() {
        $videothumbfile = trim($this->videothumbfile);
        $smallthumbfile = trim($this->smallthumbfile);

        $videothumbfilepath =  implode('/', array_slice(explode("/", $videothumbfile), 3));        
        $smallthumbfilepath =  implode('/', array_slice(explode("/", $smallthumbfile), 3));        


        if(Storage::disk('s3')->exists($videothumbfilepath) && Storage::disk('s3')->size($videothumbfilepath) > 0) {
            return $videothumbfile;
        }
        else if(Storage::disk('s3')->exists($smallthumbfilepath) && Storage::disk('s3')->size($smallthumbfilepath) > 0) {
            return $smallthumbfile;
        }
        else {
            return '';
        }
    }

    public function getSmallthumbimagefilepathAttribute() {
        $mediafile = trim($this->mediafile);
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
        else if(!empty(trim($mediafile))) {
            return $mediafile;
        }
        else {
            return asset('images/no-images/user.png');
        }
    }

    public function getMediumthumbimagefilepathAttribute() {
        $mediafile = trim($this->mediafile);
        $mediumthumbfile = trim($this->mediumthumbfile);
        $largethumbfile = trim($this->largethumbfile);

        if(!empty(trim($mediumthumbfile))) {
            return $mediumthumbfile;
        }
        else if(!empty(trim($largethumbfile))) {
            return $largethumbfile;
        }
        else if(!empty(trim($mediafile))) {
            return $mediafile;
        }
        else {
            return asset('images/no-images/user.png');
        }
    }

    public function getLargethumbimagefilepathAttribute() {
        $mediafile = trim($this->mediafile);
        $largethumbfile = trim($this->largethumbfile);

        if(!empty(trim($largethumbfile))) {
            return $largethumbfile;
        }
        else if(!empty(trim($mediafile))) {
            return $mediafile;
        }
        else {
            return asset('images/no-images/user.png');
        }
    }
}
