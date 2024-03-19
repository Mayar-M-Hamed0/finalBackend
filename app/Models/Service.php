<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_name', 'service_details', 'image', 'user_id' , 'price',
    ];

    public function serviceCenters()
    {
        return $this->belongsToMany(ServiceCenter::class, 'service_center_services');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function orders()
    {
        return $this->belongsToMany(Order::class, 'service_order', 'service_id', 'order_id');
    }
}
