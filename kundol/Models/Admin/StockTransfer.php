<?php

namespace App\Models\Admin;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class StockTransfer extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'stock_transfer';

    protected $fillable = [
        'reference_no', 'trasfer_date', 'notes', 'warehouse_from', 'warehouse_to',
    ];

    public function from_warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_from');
    }

    public function to_warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_to');
    }

    public function stock_transfer_detail()
    {
        return $this->hasMany(StockTransferDetail::class);
    }

    public function getUpdatedAtAttribute($value) {
        return Carbon::parse($value)->format('d-m-Y H:i:s');
    }
    public function getCreatedAtAttribute($value) {
        return Carbon::parse($value)->format('d-m-Y H:i:s');
    }
}
