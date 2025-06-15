<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    // Define the table associated with the model (optional if it follows Laravel's naming conventions)
    protected $table = 'appointments';

    // Define the fillable properties to allow mass assignment
    protected $fillable = [
        'applicant_id',
        'slot_id',
        'status',
    ];

    /**
     * Define the relationship with the Applicant (User).
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function applicant()
    {
        return $this->belongsTo(User::class, 'applicant_id');
    }

    /**
     * Define the relationship with the Slot (AvailableSlot).
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function slot()
    {
        return $this->belongsTo(AvailableSlot::class, 'slot_id');
    }
}
