<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdPostMedia extends Model
{
    use HasFactory;

    protected $table = 'ad_post_media';

    protected $primaryKey = 'ad_post_media_id';
}
