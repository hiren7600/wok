<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupDiscussionComment extends Model
{
    use HasFactory;

    protected $table        = 'group_discussion_comments';

    protected $primaryKey   = 'group_discussion_comment_id';

    public function user() {
        return $this->belongsTo('App\Models\User','user_id');
    }

    public function replycomments() {
        return $this->hasMany('App\Models\GroupDiscussionComment', 'parent_id')->oldest();
    }
}
