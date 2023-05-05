<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    use HasFactory;

    protected $table        = 'friends';

    protected $primaryKey   = 'friend_id';


    public function touser() {
        return $this->belongsTo('App\Models\User', 'to_user_id', 'user_id');
    }

    public function fromuser() {
        return $this->belongsTo('App\Models\User', 'user_id', 'user_id');
    }
}
