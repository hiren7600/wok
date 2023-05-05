<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $table        = 'posts';

    protected $primaryKey   = 'post_id';


    public function user() {
        return $this->belongsTo('App\Models\User', 'user_id', 'user_id');
    }

    public function media() {
        return $this->hasOne('App\Models\Postmedia', 'post_id', 'post_id')->where('type', 0);
    }

    public function comments() {
        return $this->hasMany('App\Models\Comment', 'post_id', 'post_id')->oldest();
    }
}
