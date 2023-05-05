<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\GroupDiscussionRead;

class GroupDiscussion extends Model
{
    use HasFactory;

    protected $table        = 'group_discussions';

    protected $primaryKey   = 'group_discussion_id';

    protected $appends      = [
        'isdiscussionread',
    ];

    public function getIsdiscussionreadAttribute() {
        $user_id = auth()->user()->user_id;
        $group_id = $this->group_id;
        $group_discussion_id = $this->group_discussion_id;
        
        $flag = 1;
        $groupdiscussionread = GroupDiscussionRead::where('user_id', $user_id)->where('group_id', $group_id)->where('group_discussion_id', $group_discussion_id)->first();
        
        if(empty($groupdiscussionread)) {
            $flag = 0;
        }
        

        return $flag;

    }

    public function user() {
        return $this->belongsTo('App\Models\User','user_id');
    }

    // public function comments() {
    //     return $this->hasMany('App\Models\GroupDiscussionComment','group_discussion_id');
    // }

    public function comments() {
        return $this->hasMany('App\Models\GroupDiscussionComment', 'group_discussion_id', 'group_discussion_id')->where('parent_id', null);
    }

    public function allcomments() {
        return $this->hasMany('App\Models\GroupDiscussionComment', 'group_discussion_id', 'group_discussion_id');
    }

    public function likes() {
        return $this->hasMany('App\Models\GroupDiscussionLike', 'group_discussion_id');
    }

    public function discussionviews() {
        return $this->hasMany('App\Models\GroupDiscussionView','group_discussion_id');
    }


}
