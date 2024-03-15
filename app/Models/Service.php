<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_name', 'service_details', 'image',
    ];

    public function serviceCenters()
    {
        return $this->belongsToMany(ServiceCenter::class, 'service_center_services');
    }
}
