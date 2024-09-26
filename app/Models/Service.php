<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'service',
        'description',
        'price',
        'is_active',
        'category_id'
    ];

    public function category()
    {
        return $this->belongsTo('App\Models\Dropdown', 'category_id', 'id');
    }

}
