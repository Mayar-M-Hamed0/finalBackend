<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ServiceCenterService extends Pivot
{
    protected $table = 'service_center_services'; 

    
    public $timestamps = true; 
}

