<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class SaleQuotation extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'customer_id','desc','payable','discount','tax_id','tax_amount','amount_paid','due_amount','sale_date','warehouse_id','created_by','updated_by'
    ];

    public function scopeSaleQuotationId($query, $id)
    {
        return $query->where('id', $id);
    }

    public function detail()
    {
        return $this->hasMany('App\Models\Admin\SaleQuotationDetail');
    }

    public function customer()
    {
        return $this->belongsTo('App\Models\Admin\Customer');
    }
    
    public function warehouse()
    {
        return $this->belongsTo('App\Models\Admin\Warehouse');
    }

    public function tax()
    {
        return $this->belongsTo('App\Models\Admin\Tax');
    }
}
