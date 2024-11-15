<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dropdown extends Model
{
    use HasFactory;

    public function services()
    {
        return $this->hasMany('App\Models\Service', 'category_id');
    } 

    public function aestheticians()
    {
        return $this->hasMany('App\Models\AestheticianService', 'category_id');
    } 
}
