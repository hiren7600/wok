<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdPost extends Model
{
    use HasFactory;

    protected $table = 'ad_posts';

    protected $primaryKey = 'ad_post_id';


    public function user() {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function adcategory() {
        return $this->belongsTo('App\Models\AdCategory', 'ad_category_id');
    }

    public function admedias() {
        return $this->hasMany('App\Models\AdPostMedia', 'ad_post_id');
    }

    public function scopeSearch($query, $value) {
        if(!empty(trim($value))) {
            $value = trim($value);
            $query->where('ad_posts.title', 'LIKE', '%'.$value.'%')
                  ->orWhere('ad_posts.content', 'LIKE', '%'.$value.'%')
                  ->orWhere('ad_posts.location', 'LIKE', '%'.$value.'%');
        }
        return $query;
    }
}
