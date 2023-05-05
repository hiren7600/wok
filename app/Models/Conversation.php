<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    protected $table        = 'conversations';

    protected $primaryKey   = 'conversation_id';

    public function conversationmessages() {
        return $this->hasMany('App\Models\ConversationMessage', 'conversation_id', 'conversation_id');
    }
    public function touser() {
        return $this->belongsTo('App\Models\User', 'to_id', 'user_id');
    }
    public function fromuser() {
        return $this->belongsTo('App\Models\User', 'from_id', 'user_id');
    }
}
