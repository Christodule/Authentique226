<?php

namespace App\Repository\Admin;

use App\Contract\Admin\PurchaseInterface;
use App\Http\Resources\Admin\Purchase as PurchaseResource;
use App\Models\Admin\Inventory;
use App\Models\Admin\Language;
use App\Models\Admin\Purchase;
use App\Models\Admin\PurchaseDetail;
use App\Services\Admin\PurchaseDetailService;
use App\Traits\ApiResponser;
use App\Traits\Transactions;
use DB;


class PurchaseRepository implements PurchaseInterface
{
    use ApiResponser;
    use Transactions;
    public function all()
    {
        $purchase = new Purchase;
        if (isset($_GET['getSupplier']) && $_GET['getSupplier'] == '1') {
            $purchase = $purchase->with('supplier');
        }
        if (isset($_GET['getPurchaseDetail']) && $_GET['getPurchaseDetail'] == '1') {
            $purchase = $purchase->with('purchase_detail');
        }
        $languageId = Language::defaultLanguage()->value('id');
        if (isset($_GET['language_id']) && $_GET['language_id'] != '') {
            $language = Language::languageId($_GET['language_id'])->firstOrFail();
            $languageId = $language->id;
        }
        if (isset($_GET['getProductDetail']) && $_GET['getProductDetail'] == '1') {
            $purchase = $purchase->with('purchase_detail.product.detail', function ($querys) use ($languageId) {
                $querys->where('language_id', $languageId);
            });
        }
        if (isset($_GET['getProductCombinationDetail']) && $_GET['getProductCombinationDetail'] == '1') {
            $purchase = $purchase->with('purchase_detail.product_combination');
        }
        if (isset($_GET['getWarehouse']) && $_GET['getWarehouse'] == '1') {
            $purchase = $purchase->with('warehouse');
        }

        if (isset($_GET['onlyComplete']) && $_GET['onlyComplete'] == '1') {
            $purchase = $purchase->purchaseStatus();
        }

        
        
        if (isset($_GET['limit']) && is_numeric($_GET['limit']) && $_GET['limit'] > 0) {
            $numOfResult = $_GET['limit'];
        } else {
            $numOfResult = 100;
        }

        if (isset($_GET['searchParameter']) && $_GET['searchParameter'] != '') {
            $search = $_GET['searchParameter'];
            $purchase = $purchase->Where(function ($query) use ($search) {
                $query->whereHas('purchaser', function ($query) use ($search) {
                    $query->where('purchaser.first_name', 'like', '%' . $search . '%')->orWhere('purchaser.last_name', 'like', '%' . $search . '%');
                })->orWhereHas('warehouse', function ($query) use ($search) {
                    $query->where('warehouses.name', 'like', '%' . $search . '%');
                })->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        $sortBy = ['id', 'total_amount', 'amount_paid', 'discount_amount', 'amount_due', 'purchase_date'];
        $sortType = ['ASC', 'DESC', 'asc', 'desc'];
        if (isset($_GET['sortBy']) && $_GET['sortBy'] != '' && isset($_GET['sortType']) && $_GET['sortType'] != '' && in_array($_GET['sortBy'], $sortBy) && in_array($_GET['sortType'], $sortType)) {
            $purchase = $purchase->orderBy($_GET['sortBy'], $_GET['sortType']);
        }

        
        try {
            return $this->successResponse(PurchaseResource::collection($purchase->paginate($numOfResult)), 'Data Get Successfully!');
        } catch (Exception $e) {
            return $this->errorResponse();
        }
    }

    public function show($purchase)
    {
        $purchase = Purchase::purchaseId($purchase->id);
        if (isset($_GET['getSupplier']) && $_GET['getSupplier'] == '1') {
            $purchase = $purchase->with('supplier');
        }
        if (isset($_GET['getPurchaseDetail']) && $_GET['getPurchaseDetail'] == '1') {
            $purchase = $purchase->with('purchase_detail');
        }
        $languageId = Language::defaultLanguage()->value('id');
        if (isset($_GET['language_id']) && $_GET['language_id'] != '') {
            $language = Language::languageId($_GET['language_id'])->firstOrFail();
            $languageId = $language->id;
        }
        if (isset($_GET['getProductDetail']) && $_GET['getProductDetail'] == '1') {
            $purchase = $purchase->with('purchase_detail.product.detail', function ($querys) use ($languageId) {
                $querys->where('language_id', $languageId);
            });
        }
        if (isset($_GET['getProductCombinationDetail']) && $_GET['getProductCombinationDetail'] == '1') {
            $purchase = $purchase->with('purchase_detail.product_combination');
        }
        if (isset($_GET['getWarehouse']) && $_GET['getWarehouse'] == '1') {
            $purchase = $purchase->with('warehouse');
        }
        try {

            return $this->successResponse(new PurchaseResource($purchase->firstOrFail()), 'Data Get Successfully!');
        } catch (Exception $e) {
            return $this->errorResponse();
        }
    }

    public function store(array $parms)
    {
        DB::beginTransaction();
        try {
            $sql = new Purchase;
            $parms['created_by'] = \Auth::id();
            $purchase = $sql->create($parms);
        } catch (Exception $e) {
            DB::rollBack();
            return $this->errorResponse();
        }

        if ($sql) {
            $transaction_id = $this->saveTransaction("Purchase product");
            $this->saveTransactionDetail($parms['supplier_id'],0,$parms['total_amount'],11,$transaction_id,"purchase",'supplier');
            $purchaseDetailService = new PurchaseDetailService;
            $sql = $purchaseDetailService->store($parms, $purchase->id, $purchase->warehouse_id,$transaction_id,'supplier');
        }

        if ($sql) {
            DB::commit();
            return $this->successResponse(new PurchaseResource($purchase), 'Purchase Save Successfully!');
        } else {
            DB::rollBack();
            return $this->errorResponse();
        }
    }

    public function destroy($purchase)
    {
        DB::beginTransaction();
        try {
            $sql = Purchase::findOrFail($purchase);
            $sql->delete();
        } catch (Exception $e) {
            DB::rollBack();
            return $this->errorResponse();
        }
        if ($sql) {
            DB::commit();
            return $this->successResponse('', 'Purchase Delete Successfully!');
        } else {
            DB::rollBack();
            return $this->errorResponse();
        }
    }

    public function updateStatus($parms,$purchase){

        DB::beginTransaction();
        try {
            $sql = $purchase->update([
                'purchase_status' => $parms['status']
            ]);
        } catch (Exception $e) {
            DB::rollback();
            return $this->errorResponse();
        }

        if ($sql) {
            $purchase = Purchase::where('id',$purchase->id)->first();
            $transaction_id = $this->saveTransaction("Purchase product");
            $this->saveTransactionDetail($purchase->supplier_id,$purchase->total_amount,0,11,$transaction_id,"purchase",'supplier');
            $purchaseDetails = PurchaseDetail::where('purchase_id',$purchase->id)->get();
            foreach ($purchaseDetails as $key => $purchaseDetail) {
                Inventory::insertOrIgnore([
                    'product_id' => $purchaseDetail->product_id,
                    'warehouse_id' => $purchase->warehouse_id,
                    'stock_status' => 'OUT',
                    'qty' => $purchaseDetail->qty,
                    'qty' => $purchaseDetail->price,
                    'reference_id' => $purchase->id,
                    'product_combination_id' => $purchaseDetail->product_combination_id,
                    'stock_type' => 'PurchaseReturn',
                    'created_by' => \Auth::id(),
                    'updated_at' => \Carbon\Carbon::now(),
                ]);
                $refrence_id = $purchaseDetail->product_combination_id != null ? $purchaseDetail->product_combination_id : $purchaseDetail->product_id;
                $account_type = $purchaseDetail->product_combination_id != null ? 'variable_product' :'simple_product';
                $this->saveTransactionDetail($refrence_id,0,$purchaseDetail->price * $purchaseDetail->qty,6,$transaction_id,"purchase",$account_type,$purchase->warehouse_id);
            }
            DB::commit();
            return $this->successResponse(new PurchaseResource($purchase), 'Purchase Status Updated Successfully!');
        } else {
            DB::rollback();
            return $this->errorResponse();
        }
    
    }
}
