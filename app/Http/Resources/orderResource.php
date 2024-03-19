<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class orderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return  [
            "name"=>$this->user->name,
            "car_model"=>$this->car_model,
            "email"=>$this->user->email,
            "img"=>$this->user->image,
            'service_name' => $this->services->pluck('service_name'),
            "location"=>$this->serviceCenter->location,
            "phone"=>$this->phone,
            "notice"=>$this->order_details
        ];
        // return parent::toArray($request);
    }
}
