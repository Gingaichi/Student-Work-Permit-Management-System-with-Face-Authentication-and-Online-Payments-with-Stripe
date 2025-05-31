<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SystemSettings extends Model
{
    use HasFactory;

    protected $fillable = [
        'start_date',
        'start_time',
        'end_time',
        'max_per_hour',
    ];
}
