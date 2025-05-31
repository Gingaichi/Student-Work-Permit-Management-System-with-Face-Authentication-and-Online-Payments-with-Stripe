<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class ImmigrationOfficer extends Authenticatable
{
    protected $table = 'immigration_officer'; // Set the table name
    protected $fillable = ['email', 'password'];
}
?>