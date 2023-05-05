<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\GroupDiscussionRead;

class Group extends Model
{
    use HasFactory;

    protected $table        = 'groups';

    protected $primaryKey   = 'group_id';

    protected $appends      = [
        'membercount',
        'commentcount',
        'isgroupread',
    ];

    public function getCommentcountAttribute() {
        return $this->discussioncomments()->count();
    }

    public function getMembercountAttribute() {
        return $this->members()->count();
    }

    public function getIsgroupreadAttribute() {
        $user_id = auth()->user()->user_id;
        $group_id = $this->group_id;
        
        $discussions = $this->discussions;
        $discussionreadArr = GroupDiscussionRead::where('user_id', $user_id)->where('group_id', $group_id)->where('group_discussion_id', '!=', null)->get()->pluck('group_discussion_id')->toArray();

        $flag = 1;
        $groupread = GroupDiscussionRead::where('user_id', $user_id)->where('group_id', $group_id)->where('group_discussion_id', null)->first();
        
        if(empty($groupread)) {
            $flag = 0;
        }
        foreach($discussions as $discussion) {
            if(!in_array($discussion->group_discussion_id, $discussionreadArr)) {
                if($flag == 1) {
                    $flag = 0;
                }
            }
        }

        return $flag;

    }

    public function user() {
        return $this->belongsTo('App\Models\User','user_id');
    }

    public function members() {
        return $this->hasMany('App\Models\GroupMember','group_id');
    }

    public function discussions() {
        return $this->hasMany('App\Models\GroupDiscussion','group_id');
    }


    public function discussioncomments() {
        return $this->hasManyThrough('App\Models\GroupDiscussionComment', 'App\Models\GroupDiscussion', 'group_id', 'group_discussion_id');
    }

    public function scopeSearch($query, $value){

        if(!empty(trim($value))) {
            $query->where(function($query)  use ($value) {
                $query->Where('title', 'LIKE', "%$value%")
                      ->orWhere('description', 'LIKE', "%$value%");
            });
        }

        return $query;
    }
}
