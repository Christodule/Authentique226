<?php 
namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleQuotationDetail extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'sale_quotation_id','product_id','product_combination_id','qty','price','total'
    ];

    public function saleQuotation()
    {
        return $this->belongsTo('App\Models\Admin\SaleQuotation');
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Admin\Product');
    }

    public function product_combination()
    {
        return $this->belongsTo('App\Models\Admin\ProductCombination','product_combination_id', 'id');
    }

    public function scopeProductCombinationSale($query, $productId, $productCombinationId, $saleId)
    {
        return $query->where('product_id', $productId)->where('product_combination_id', $productCombinationId)->where('sale_id', $saleId);
    }

    public function scopeProductSale($query, $productId, $saleId)
    {
        return $query->where('product_id', $productId)->where('sale_id', $saleId);
    }

}
