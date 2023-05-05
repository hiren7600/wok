<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usertoken extends Model
{
    use HasFactory;
    
    protected $table        = 'usertokens';
    protected $primaryKey   = 'usertoken_id';
}
