<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentReason extends Model
{
    use HasFactory;
    
    protected $fillable = ['reason','appointment_id','user_id'];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function appointment()
    {
        return $this->belongsTo('App\Models\Appointment', 'appointment_id', 'id');
    }
}
