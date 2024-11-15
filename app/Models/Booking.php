<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = ['date','aesthetician_id','service_id','user_id'];

    public function aesthetician()
    {
        return $this->belongsTo('App\Models\Aesthetician', 'aesthetician_id', 'id');
    }

    public function service()
    {
        return $this->belongsTo('App\Models\Service', 'service_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
    public function getDateAttribute($value)
    {
        return date('M d, Y g:i a', strtotime($value));
    }
}
