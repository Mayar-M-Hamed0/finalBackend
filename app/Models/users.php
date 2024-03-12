<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class users extends Model
{
    use HasFactory;

    protected $table = 'usersapi';

    protected $fillable = [
        'fname',
        'lname',
        'email',
        'phone',
        'password',
        // 'role',
        'remember_token',
    ];

     protected $hidden = [
        'remember_token',
        // 'role',
    ];

    //  protected $casts = [
    //     'email_verified_at' => 'datetime',
    // ];

    
}
