<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupDiscussionLike extends Model
{
    use HasFactory;

    protected $table        = 'group_discussion_likes';

    protected $primaryKey   = 'group_discussion_like_id';
}
