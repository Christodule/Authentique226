<?php

namespace App\Http\Resources\Admin;

use App\Http\Resources\Admin\Country as CountryResource;
use App\Http\Resources\Admin\State as StateResource;
use Illuminate\Http\Resources\Json\JsonResource;

class Supplier extends JsonResource
{
    public function toArray($request)
    {
        return [
            'supplier_id' => $this->id,
            'supplier_first_name' => $this->first_name,
            'supplier_last_name' => $this->last_name,
            'supplier_address' => $this->address,
            'supplier_phone' => $this->phone,
            'supplier_mobile' => $this->mobile,
            'country' => new CountryResource($this->whenLoaded('country')),
            'state' => new StateResource($this->whenLoaded('state')),
            'supplier_city' => $this->city,
        ];
    }
}
