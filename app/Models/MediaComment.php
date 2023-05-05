<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MediaComment extends Model
{
    use HasFactory;
    
    protected $table        = 'media_comments';

    protected $primaryKey   = 'media_comment_id';


    public function user() {
        return $this->belongsTo('App\Models\User', 'user_id', 'user_id');
    }

    public function replycomments() {
        return $this->hasMany('App\Models\MediaComment', 'parent_id')->oldest();
    }
}
