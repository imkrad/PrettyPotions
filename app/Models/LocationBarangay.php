<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocationBarangay extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'code';
    protected $keyType = 'string';

    public function municipality()
    {
        return $this->belongsTo('App\Models\LocationMunicipality', 'municipality_code', 'code');
    }

    public function scholars()
    {
        return $this->hasMany('App\Models\ProfileAddress', 'municipality_code');
    } 
}
