<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMediaView extends Model
{
    use HasFactory;

    protected $table        = 'user_media_views';

    protected $primaryKey   = 'user_media_view_id';
}
