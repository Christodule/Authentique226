<?php

namespace App\Http\Resources\Admin;

use App\Http\Resources\Admin\PurchaseDetail as PurchaseDetailResource;
use App\Http\Resources\Admin\Supplier as SupplierResource;
use App\Http\Resources\Admin\Warehouse as WarehouseResource;
use Illuminate\Http\Resources\Json\JsonResource;

class Purchase extends JsonResource
{
    public function toArray($request)
    {
        return [
            'purchase_id' => $this->id,
            'supplier' => new SupplierResource($this->whenLoaded('supplier')),
            'purchase_date' => $this->purchase_date,
            'description' => $this->description,
            'total_amount' => $this->total_amount,
            'amount_paid' => $this->amount_paid,
            'discount_amount' => $this->discount_amount,
            'amount_due' => $this->amount_due,
            'purchase_detail' => $this->purchase_detail,
            'purchase_status' => $this->purchase_status,
            'detail' => PurchaseDetailResource::collection($this->whenLoaded('purchase_detail')),
            'warehouse' => new WarehouseResource($this->whenLoaded('warehouse')),
        ];
    }
}
