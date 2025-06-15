<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Studentpermit extends Model
{

    protected $fillable = [
        'name',
        'email',
        'phone',
        'dob',
        'nationality',
        'id_number',
        'course',
        'institution',
        'current_address',
        'duration',
        'app_letter',
        'passport_photo',
        'birth_certificate',
        'user_id'
        // If you are handling the passport picture, add it to the fillable array as well
        // 'passport_picture',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function rejections()
{
    return $this->hasMany(Reject::class);
}
}
