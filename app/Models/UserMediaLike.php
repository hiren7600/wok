<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMediaLike extends Model
{
    use HasFactory;

    protected $table        = 'user_media_likes';

    protected $primaryKey   = 'user_media_like_id';

    public function user() {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function usermedia() {
        return $this->belongsTo('App\Models\UserMedia', 'media_id');
    }
}
