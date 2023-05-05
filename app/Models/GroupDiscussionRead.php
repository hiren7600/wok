<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupDiscussionRead extends Model
{
    use HasFactory;

    protected $table        = 'group_discussion_reads';

    protected $primaryKey   = 'group_discussion_read_id';
}
