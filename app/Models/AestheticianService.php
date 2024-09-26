<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AestheticianService extends Model
{
    use HasFactory;

    protected $fillable = [
        'aesthetician_id','category_id'
    ];

    public function aesthetician()
    {
        return $this->belongsTo('App\Models\Aesthetician', 'aesthetician_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Dropdown', 'category_id', 'id');
    }
}
