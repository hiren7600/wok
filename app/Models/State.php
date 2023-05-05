<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;

    protected $table        = 'states';

    protected $primaryKey   = 'stateid';

    public function scopeActive($query){
		return $query->where('status', 1);
	}

    public function cities() {
        return $this->hasMany('App\Models\City', 'stateid');
    }

    public function country() {
        return $this->belongsTo('App\Models\Country', 'countryid');
    }
}
