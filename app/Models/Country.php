<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $table = 'countries';

	protected $primaryKey = 'countryid';

	public function scopeActive($query){
		return $query->where('status', 1);
	}

	public function states() {
        return $this->hasMany('App\Models\State', 'countryid')->where('status',1);
    }
}
