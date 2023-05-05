<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupDiscussionView extends Model
{
    use HasFactory;

    protected $table        = 'group_discussion_views';

    protected $primaryKey   = 'group_discussion_view_id';
}
