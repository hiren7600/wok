<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KinkMember extends Model
{
    use HasFactory;

    protected $table        = 'kink_members';

    protected $primaryKey   = 'kink_member_id';

    public function membertag() {
        return $this->hasOne('App\Models\Tag', 'tag_id', 'tag_id');
    }

    public function kinkmembers() {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
