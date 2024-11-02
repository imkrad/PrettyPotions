<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = ['code','total','date','is_resched','is_walkin','is_rated','us_seened','user_id','status_id'];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function status()
    {
        return $this->belongsTo('App\Models\Dropdown', 'status_id', 'id');
    }

    public function lists()
    {
        return $this->hasMany('App\Models\AppointmentService', 'appointment_id');
    } 

    public function review()
    {
        return $this->hasOne('App\Models\Review', 'appointment_id');
    } 

    public function reason()
    {
        return $this->hasOne('App\Models\AppointmentReason', 'appointment_id');
    } 

    public function getDateAttribute($value)
    {
        return date('M d, Y g:i a', strtotime($value));
    }

    public function getUpdatedAtAttribute($value)
    {
        return date('M d, Y g:i a', strtotime($value));
    }

    public function getCreatedAtAttribute($value)
    {
        return date('M d, Y g:i a', strtotime($value));
    }
}
