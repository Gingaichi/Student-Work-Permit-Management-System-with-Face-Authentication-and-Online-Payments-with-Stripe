<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reject extends Model
{
    protected $table = 'rejections';
    
    protected $fillable = [
        'studentpermit_id',
        'officer_id',
        'reason'
    ];

    public function studentPermit()
    {
        return $this->belongsTo(Studentpermit::class, 'studentpermit_id');
    }

    public function officer()
    {
        return $this->belongsTo(User::class, 'officer_id');
    }
}

