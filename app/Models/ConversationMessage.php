<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConversationMessage extends Model
{
    use HasFactory;

    protected $table        = 'conversation_messages';

    protected $primaryKey   = 'conversation_message_id';

    public function user() {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
