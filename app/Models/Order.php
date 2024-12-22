<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'service',
        'price',
        'payment_url',
        'status',
        'duration',
        'clinic_id',
        'schedule',
    ];

    public function patient()
    {
        return $this->belongsTo(User::class . 'patient_id');
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }
}
