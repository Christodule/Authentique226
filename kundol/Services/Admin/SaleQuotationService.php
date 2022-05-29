<?php

namespace App\Services\Admin;

use App\Http\Requests\SaleQuotationDetailRequest;
use App\Models\Admin\Inventory;
use App\Models\Admin\SaleQuotationDetail;
use App\Services\Admin\AvailableQty;
use App\Traits\ApiResponser;
use Illuminate\Foundation\Validation\ValidatesRequests;

class SaleQuotationService
{
    use ValidatesRequests, ApiResponser;
    public function saleQuotationDetailData($parms, $id, $type, $warehouseId)
    {
        if ($type == 'update') {
            SaleQuotationDetail::where('sale_quotation_id', $id)->delete();
        }
        
        $data['sale_quotation_id'] = $id;
        
        foreach ($parms['product_id'] as $i => $saleQuotationDetail) {
            if (!isset($parms['qty'][$i]) || (isset($parms['qty'][$i]) && $parms['qty'][$i] == 0)) {
                continue;
            }
            try {
                ;
                $data['product_id'] = $saleQuotationDetail;
                $data['product_combination_id'] = $parms['product_combination_id'][$i];
                $data['qty'] = $parms['qty'][$i];
                $data['price'] = $parms['price'][$i];
                $data['total'] = $parms['total'][$i];
                $query = new SaleQuotationDetail;
                $query = $query->create($data);
            } catch (Exception $e) {
                \DB::rollBack();
                return $this->errorResponse('Purchase can not saved due to internal server error!', 422);
            }

            try {
                Inventory::create([
                    'product_id' => $data['product_id'],
                    'warehouse_id' => $warehouseId,
                    'customer_id' => null,
                    'stock_status' => 'OUT',
                    'reference_id' => $query->id,
                    'qty' => $data['qty'],
                    'product_combination_id' => $data['product_combination_id'],
                    'stock_type' => 'SaleQuotation',
                ]);
            } catch (Exception $e) {
                \DB::rollBack();
                return $this->errorResponse('Purchase can not saved due to internal server error!', 422);
            }
        }

        return 1;
    }

    public function saleQuotationDetailValidate($parms)
    {
        $request = new SaleQuotationDetailRequest;
        $this->validate($parms, $request->rules());

        $message = '';
        if (!isset($parms['product_combination_id'])) {
            $message = 'product_combination_id is required.';
        }
        if ($message == '' && !is_array($parms['product_combination_id'])) {
            $message = 'product_combination_id must be in array.';
        }
        if ($message == '' && count($parms['product_id']) != count($parms['product_combination_id'])) {
            $message = 'product_combination_id is required.';
        }

        if ($message != '') {
            return $this->errorResponse($message, 422);
        }

        foreach ($parms['product_id'] as $i => $saleQuotationDetail) {

            if (!isset($parms['product_id'][$i])) {
                if(isset($parms['product_name'][$i])){
                    $message = $parms['product_name'][$i] .' Product id is required';
                }
                else{
                    $message = 'product_id index ' . $i . ' is required.';
                }
            }
            if (isset($parms['qty'][$i]) && !isset($parms['price'][$i])) {
                if(isset($parms['product_name'][$i])){
                    $message = $parms['product_name'][$i] .' Price is required';
                }
                else{
                    $message = 'price index ' . $i . ' is required.';
                }
            }
            if (!isset($parms['total'][$i])) {
                if(isset($parms['product_name'][$i])){
                    $message = $parms['product_name'][$i] .' total is required';
                }
                else{
                    $message = 'total index ' . $i . ' is required.';
                }
            }
            if ($message != '') {
                return $this->errorResponse($message, 422);
            }

            if (isset($parms['qty'][$i])) {
                $availableQty = new AvailableQty;
                $availableQty = $availableQty->availableQty($saleQuotationDetail, $parms['product_combination_id'][$i], $parms['qty'][$i]);
                if (!$availableQty) {
                    return $this->errorResponse('Out of Stock with Qty index ' . $i . '', 422);
                }
            }
        }


        if ($message != '') {
            return $this->errorResponse($message, 422);
        }

        return 1;
    }
}
