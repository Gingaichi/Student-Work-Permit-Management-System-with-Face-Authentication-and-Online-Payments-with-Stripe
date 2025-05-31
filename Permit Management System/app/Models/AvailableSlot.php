<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AvailableSlot extends Model
{
    use HasFactory;

    protected $fillable = ['date', 'slot_time', 'is_booked'];

    public function appointments()
{
    return $this->hasMany(Appointment::class, 'slot_id');
}
}
