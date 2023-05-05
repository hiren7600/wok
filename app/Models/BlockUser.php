<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlockUser extends Model
{
    use HasFactory;

    protected $table = 'block_users';

	protected $primaryKey = 'block_user_id';

    public function user() {
        return $this->hasOne('App\Models\User', 'user_id', 'user_id');
    }
}
