<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocationMunicipality extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'code';
    protected $keyType = 'string';

    public function province()
    {
        return $this->belongsTo('App\Models\LocationProvince', 'province_code', 'code');
    }

    public function barangays()
    {
        return $this->hasMany('App\Models\LocationBarangay', 'municipality_code');
    } 

    public function scholars()
    {
        return $this->hasMany('App\Models\ProfileAddress', 'municipality_code');
    } 
}
