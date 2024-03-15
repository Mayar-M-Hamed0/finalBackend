<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ServiceCenterService extends Pivot
{
    protected $table = 'service_center_services'; // Name of the pivot table

    // Optionally, define any additional configurations, such as timestamps
    public $timestamps = true; // Assuming the pivot table has timestamps
}

