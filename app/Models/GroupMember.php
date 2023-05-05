<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupMember extends Model
{
    use HasFactory;

    protected $table        = 'group_members';

    protected $primaryKey   = 'group_member_id';

    public function user() {
        return $this->belongsTo('App\Models\User','user_id');
    }

    public function group() {
        return $this->belongsTo('App\Models\Group','group_id');
    }
}
