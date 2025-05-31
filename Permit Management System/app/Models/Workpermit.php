<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Workpermit extends Model
{

    protected $fillable = [
        'name',
        'email',
        'phone',
        'dob',
        'nationality',
        'passport_number',
        'job_title',
        'employer',
        'workplace_address',
        'employment_duration',
        'app_letter',
        'passport_photo',
        'employment_contract',
        'cv',
        'professional_clearance',
        'user_id'
        // If you are handling the passport picture, add it to the fillable array as well
        // 'passport_picture',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
