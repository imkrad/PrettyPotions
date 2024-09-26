<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocationProvince extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $primaryKey = 'code';
    protected $keyType = 'string';

    public function region()
    {
        return $this->belongsTo('App\Models\LocationRegion', 'region_code', 'code');
    }

    public function municipalities()
    {
        return $this->hasMany('App\Models\LocationMunicipality', 'province_code');
    } 

    public function scholars()
    {
        return $this->hasMany('App\Models\ScholarAddress', 'province_code');
    } 

    public function profile()
    {
        return $this->morphOne('App\Models\UserProfile', 'profileable');
    }
}
