<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ServiceCenterCar extends Pivot
{
    protected $table = 'service_center_cars'; 

    public $timestamps = true; 
}