<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class City extends Model
{
    use HasFactory;

    protected $table = 'cities';

	protected $primaryKey = 'cityid';

	protected $appends      = [
        'membercount'
    ];

    public function getMembercountAttribute() {
        $cityname = trim($this->cityname);
        $usercounts = User::where('address', 'LIKE', '%'.$cityname.'%')->get()->count();

        return $usercounts;
    }

    public function scopeActive($query){
		return $query->where('status', 1);
	}

	public function state() {
        return $this->belongsTo('App\Models\State', 'stateid');
    }

}
