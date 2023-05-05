<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Postmedia extends Model
{

    use HasFactory;

    protected $table        = 'postmedia';

    protected $primaryKey   = 'postmedia_id';


    protected $appends      = [
        'filesize',
    ];

    public function getFilesizeAttribute() {

        $imagefile =  implode('/', array_slice(explode("/", $this->path), 3));

        if(Storage::disk('s3')->exists($imagefile)) {

            $imagefilesize = Storage::disk('s3')->size($imagefile);

            if ($imagefilesize < 1000000) {
                $result = $this->path;
            }else{
                $result = $this->largethumbfile;
            }
            return $result;
        }
        else {
            return asset('images/no-images/noimage.jpg');
        }

    }
}
