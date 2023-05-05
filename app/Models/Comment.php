<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $table        = 'comments';

    protected $primaryKey   = 'comment_id';

    public function user() {
        return $this->belongsTo('App\Models\User', 'user_id', 'user_id');
    }

    public function media() {
        return $this->hasOne('App\Models\Postmedia', 'comment_id', 'comment_id')->where('type', 1);
    }
}
