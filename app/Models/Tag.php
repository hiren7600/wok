<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $table        = 'tags';

    protected $primaryKey   = 'tag_id';

    public function members() {
        return $this->hasMany('App\Models\KinkMember', 'tag_id');
    }

    protected $appends      = [
        'tagcount'
    ];

    public function getTagcountAttribute() {
        $tag_id = trim($this->tag_id);
        $tagcounts = KinkMember::where('tag_id', $tag_id)->get()->count();
        return $tagcounts;
    }
}
