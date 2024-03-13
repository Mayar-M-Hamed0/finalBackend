<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'service_center_id','Description'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function serviceCenter()
    {
        return $this->belongsTo(ServiceCenter::class);
    }
}
