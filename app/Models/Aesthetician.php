<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aesthetician extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'specialist_id',
        'is_active'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function specialist()
    {
        return $this->belongsTo('App\Models\Dropdown', 'specialist_id', 'id');
    }

    public function lists()
    {
        return $this->hasMany('App\Models\AestheticianService', 'aesthetician_id');
    } 
}
