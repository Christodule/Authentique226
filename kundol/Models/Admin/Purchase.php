<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Purchase extends Model
{
    use SoftDeletes;

    protected $table = 'purchase';
    protected $fillable = [
        'supplier_id','purchase_status', 'warehouse_id', 'purchase_date', 'description', 'total_amount', 'amount_paid', 'discount_amount', 'amount_due', 'created_by', 'updated_by',
    ];

    public function scopePurchaseId($query, $id)
    {
        return $query->where('id', $id);
    }


    public function scopePurchaseStatus($query)
    {
        return $query->where('purchase_status','=', 'complete');
    }

    public function supplier()
    {
        return $this->belongsTo('App\Models\Admin\Supplier', 'supplier_id', 'id');
    }

    public function purchase_detail()
    {
        return $this->hasMany('App\Models\Admin\PurchaseDetail');
    }

    public function warehouse()
    {
        return $this->belongsTo('App\Models\Admin\Warehouse', 'warehouse_id', 'id');
    }

}
