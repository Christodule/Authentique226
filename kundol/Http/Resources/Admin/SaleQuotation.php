<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Admin\SaleQuotationDetail as SaleQuotationDetailResource;
use App\Http\Resources\Admin\Tax as TaxResource;
use App\Http\Resources\Admin\Customer as CustomerResource;
use App\Http\Resources\Admin\Warehouse as WarehouseResource;

class SaleQuotation extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'desc' => $this->desc,
            'sale_date' => $this->sale_date,
            'payable' => $this->payable,
            'discount' => $this->discount,
            'tax_id' => new TaxResource($this->tax),
            'tax_amount' => $this->tax_amount,
            'amount_paid' => $this->amount_paid,
            'due_amount' => $this->due_amount,
            'sale_quotation_date' => $this->aale_date,
            'customer' => new CustomerResource($this->customer),
            'warehouse' => new WarehouseResource($this->warehouse),
            'detail' =>  SaleQuotationDetailResource::collection($this->whenLoaded('detail'))
        ];
    }
}
