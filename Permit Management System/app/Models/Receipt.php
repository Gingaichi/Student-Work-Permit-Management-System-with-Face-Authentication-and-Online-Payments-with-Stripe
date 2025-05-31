<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    protected $fillable = [
        'user_id', 
        'amount', 
        'payment_date', 
        'payment_reference',
        'currency',
        'updated_at', 
        'created_at'
    ];
    
    protected $casts = [
        'payment_date' => 'datetime',
    ];

    // Add the relationship to User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}


