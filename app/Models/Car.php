<?php



namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'car_name',
    ];

    public function serviceCenters()
    {
        return $this->belongsToMany(ServiceCenter::class, 'service_center_cars');
    }
}