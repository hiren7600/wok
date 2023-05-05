<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdCategory extends Model
{
    use HasFactory;

    protected $table = 'ad_categories';

    protected $primaryKey = 'ad_category_id';


    public function adposts() {
        return $this->hasMany('App\Models\AdPost', 'ad_category_id');
    }
}
