<?php

namespace App\Models\Admin;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inventory extends Model
{
    use SoftDeletes;

    protected $table = 'inventory';

    protected $fillable = [
        'product_id', 'warehouse_id', 'customer_id', 'stock_status', 'reference_id', 'qty', 'price', 'product_combination_id', 'stock_type', 'created_by', 'updated_by',
    ];

    public function ScopeStockTransfer($query, $id)
    {
        return $query->where('stock_type', 'StockTransfer')->where('reference_id', $id);
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Admin\Product', 'product_id', 'id');
    }

    public function warehouse()
    {
        return $this->belongsTo('App\Models\Admin\Warehouse', 'warehouse_id', 'id');
    }

    public function customer()
    {
        return $this->belongsTo('App\Models\Admin\Customer', 'customer_id', 'id');
    }

    public function scopeSearchParameter($query, $parameter)
    {
        return $query->whereHas('warehouse', function ($querys) use ($parameter) {
            $querys->where('warehouses.name', 'like', '%' . $parameter . '%');
        })
        ->OrWhereHas('product', function ($querys) use ($parameter) {
            $querys->whereHas('detail',function ($querys) use ($parameter) {
                $querys->where('product_detail.title', 'like', '%' . $parameter . '%');
            });
        })
        ->Orwhere('stock_status',$parameter);
    }

    public function getUpdatedAtAttribute($value) {
        return Carbon::parse($value)->format('d-m-Y H:i:s');
    }
    public function getCreatedAtAttribute($value) {
        return Carbon::parse($value)->format('d-m-Y H:i:s');
    }


}
