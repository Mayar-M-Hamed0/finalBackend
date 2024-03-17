<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceCenter extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','name', 'phone', 'rating', 'working_days', 'working_hours', 'description', 'image','location',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function cars()
    {
        return $this->belongsToMany(Car::class, 'service_center_cars')
            ->using(ServiceCenterCar::class);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'service_center_services');
    }
}