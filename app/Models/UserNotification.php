<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserNotification extends Model
{
    use HasFactory;

    protected $table        = 'user_notifications';

    protected $primaryKey   = 'user_notification_id';

    public function user() {
        return $this->belongsTo('App\Models\User','to_user_id', 'user_id');
    }

}
