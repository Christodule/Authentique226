<?php

namespace App\Http\Controllers\API\Admin;
use App\Http\Controllers\Controller as Controller;
use App\Models\Admin\AvailableQty;
use App\Models\Admin\Product;
use App\Models\Admin\PurchaseDetail;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{


    public function __construct()
    {
    }

    public function stockOnHand()
    {
        if (isset($_GET['limit']) && is_numeric($_GET['limit']) && $_GET['limit'] > 0) {
            $numOfResult = $_GET['limit'];
        } else {
            $numOfResult = 100;
        }
        $AvailableQty = AvailableQty::with('warehouse')->
        with('current_value_simple_product')->
        with('current_value_variable_product')->
        with('product','product.detail');
        if(isset($_GET['warehouse_id']) && $_GET['warehouse_id'] != ''){
            $AvailableQty = $AvailableQty->where('warehouse_id',$_GET['warehouse_id']);
        }
        if(isset($_GET['category_id']) && $_GET['category_id'] != ''){
            $productCategory = $_GET['category_id'];
            $product = Product::type();
            $product = $product->whereHas('category', function ($query) use ($productCategory) {
                $query->where('product_category.category_id', $productCategory);
            })->pluck('id');

            $AvailableQty = $AvailableQty->whereIn('product_id',$product);
        }
        if(isset($_GET['product_id']) && $_GET['product_id'] != ''){
            $AvailableQty = $AvailableQty->where('product_id',$_GET['product_id']);
        }
        $AvailableQty = $AvailableQty->paginate($numOfResult);

        return $AvailableQty;
    }


    public function outOfStock()
    {
        if (isset($_GET['limit']) && is_numeric($_GET['limit']) && $_GET['limit'] > 0) {
            $numOfResult = $_GET['limit'];
        } else {
            $numOfResult = 100;
        }
        $AvailableQty = AvailableQty::with('warehouse')->
        with('product','product.detail');
        if(isset($_GET['warehouse_id']) && $_GET['warehouse_id'] != ''){
            $AvailableQty = $AvailableQty->where('warehouse_id',$_GET['warehouse_id']);
        }
        if(isset($_GET['category_id']) && $_GET['category_id'] != ''){
            $productCategory = $_GET['category_id'];
            $product = Product::type();
            $product = $product->whereHas('category', function ($query) use ($productCategory) {
                $query->where('product_category.category_id', $productCategory);
            })->pluck('id');

            $AvailableQty = $AvailableQty->whereIn('product_id',$product);
        }
        if(isset($_GET['product_id']) && $_GET['product_id'] != ''){
            $AvailableQty = $AvailableQty->where('product_id',$_GET['product_id']);
        }
        $AvailableQty = $AvailableQty->where('remaining',0);

        $AvailableQty = $AvailableQty->paginate($numOfResult);

        return $AvailableQty;
    }




    public function purchaseReport()
    {
        if (isset($_GET['limit']) && is_numeric($_GET['limit']) && $_GET['limit'] > 0) {
            $numOfResult = $_GET['limit'];
        } else {
            $numOfResult = 100;
        }
        $purchaseDetail = PurchaseDetail::with('product','product.detail')
        ->with('product_combination');
        if(isset($_GET['product_id']) && $_GET['product_id'] != ''){
            $purchaseDetail = $purchaseDetail->where('product_id',$_GET['product_id']);
        }
        if(isset($_GET['warehouse_id']) && $_GET['warehouse_id'] != ''){
            $warehouse_id = $_GET['warehouse_id'];
            $purchaseDetail = $purchaseDetail->whereHas('purchase',function($query) use ($warehouse_id){
                $query->where('warehouse_id',$warehouse_id);
            });
        }
       return $purchaseDetail->paginate($numOfResult);
    }

    public function expenseReport()
    {
        if (isset($_GET['limit']) && is_numeric($_GET['limit']) && $_GET['limit'] > 0) {
            $numOfResult = $_GET['limit'];
        } else {
            $numOfResult = 100;
        }
        $expenses = DB::table('expense_report')->paginate($numOfResult);
        
       return $expenses;
    }

    
}
