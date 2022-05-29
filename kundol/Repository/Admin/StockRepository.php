<?php

namespace App\Repository\Admin;

use App\Contract\Admin\StockInterface;
use App\Http\Resources\Admin\Stock as StockResource;
use App\Models\Admin\Inventory;
use App\Models\Admin\Language;
use App\Traits\ApiResponser;
use App\Traits\Transactions;
use Illuminate\Support\Collection;

class StockRepository implements StockInterface
{
    use ApiResponser;
    use Transactions;
    /**
     * @return Collection
     */
    public function all()
    {
        try {
            $stock = new Inventory;

            $languageId = Language::defaultLanguage()->value('id');
            if (isset($_GET['language_id']) && $_GET['language_id'] != '') {
                $language = Language::languageId($_GET['language_id'])->firstOrFail();
                $languageId = $language->id;
            }
            if (isset($_GET['getProduct']) && $_GET['getProduct'] == '1') {
                $stock = $stock->with('product.detail');
                $stock = $stock->with('product.detail', function ($querys) use ($languageId) {
                    $querys->where('language_id', $languageId);
                });
                // return $stock->toSql();
            }

            if (isset($_GET['limit']) && is_numeric($_GET['limit']) && $_GET['limit'] > 0) {
                $numOfResult = $_GET['limit'];
            } else {
                $numOfResult = 100;
            }

            if (isset($_GET['searchParameter']) && $_GET['searchParameter'] != '') {
                $stock = $stock->searchParameter($_GET['searchParameter']);
            }

            if (isset($_GET['date_from']) && $_GET['date_from'] != '' && isset($_GET['date_to']) && $_GET['date_to'] != '') {
                $stock = $stock->findOrderBydate($_GET['date_from'], $_GET['date_to']);
            }

            if (isset($_GET['getWarehouse']) && $_GET['getWarehouse'] == '1') {
                $stock = $stock->with('warehouse');
            }


            if (isset($_GET['stockType']) && $_GET['stockType'] != '') {
                $stock = $stock->where('stock_type',$_GET['stockType']);
            }

            $sortBy = ['id', 'created_at', 'product_id', 'warehouse_id', 'stock_status', 'qty'];
            $sortType = ['ASC', 'DESC', 'asc', 'desc'];
            if (isset($_GET['sortBy']) && $_GET['sortBy'] != '' && isset($_GET['sortType']) && $_GET['sortType'] != '' && in_array($_GET['sortBy'], $sortBy) && in_array($_GET['sortType'], $sortType)) {
                $stock = $stock->orderBy($_GET['sortBy'], $_GET['sortType']);
            }

            // return $stock->get();
            return $this->successResponse(StockResource::collection($stock->paginate($numOfResult)), 'Data Get Successfully!');
        } catch (Exception $e) {
            return $this->errorResponse();
        }
    }

    public function show($stock)
    {
        $stock = Inventory::where('id', $stock->id);
        try {

            $languageId = Language::defaultLanguage()->value('id');
            if (isset($_GET['language_id']) && $_GET['language_id'] != '') {
                $language = Language::languageId($_GET['language_id'])->firstOrFail();
                $languageId = $language->id;
            }
            if (isset($_GET['getProduct']) && $_GET['getProduct'] == '1') {
                $stock = $stock->with('product.detail', function ($querys) use ($languageId) {
                    $querys->where('language_id', $languageId);
                });
            }

            if (isset($_GET['getWarehouse']) && $_GET['getWarehouse'] == '1') {
                $stock = $stock->with('warehouse');
            }
            return $this->successResponse(new StockResource($stock->firstOrFail()), 'Data Get Successfully!');
        } catch (Exception $e) {
            return $this->errorResponse();
        }
    }

    public function store(array $parms)
    {
        \DB::beginTransaction();
        try {

            $sql = array();
            $transaction_id = $this->saveTransaction("Stock Adjustment");

            foreach ($parms['product_id'] as $i => $product_id) {
                $sql = array();
                if (isset($parms['warehouse_id'][$i]) && isset($parms['stock_status'][$i]) && isset($parms['qty'][$i]) && $parms['qty'][$i] > 0) {

                    if ($parms['warehouse_id'][$i] != null || $parms['stock_status'][$i] != null || $parms['qty'][$i] != 0) {
                        $data['product_id'] = $product_id;
                        $data['warehouse_id'] = $parms['warehouse_id'][$i];
                        $data['stock_status'] = $parms['stock_status'][$i];
                        $data['qty'] = $parms['qty'][$i];
                        $data['stock_type'] = 'StockAdjustment';
                        if (isset($parms['product_combination_id'][$i]))
                            $data['product_combination_id'] = $parms['product_combination_id'][$i];

                        $sql = new Inventory;
                        $sql = $sql->create($data);
                        if (isset($parms['product_combination_id'][$i])) {
                            if ($parms['product_combination_id'][$i] != null) {
                                $refrence_id = $parms['product_combination_id'][$i];
                                $account_type = 'variable_product';
                            }
                        } else {
                            $refrence_id = $product_id;
                            $account_type = 'simple_product';
                        }
                        if (strtolower($parms['stock_status'][$i]) == 'in') {
                            $this->saveTransactionDetail($refrence_id, $parms['price'][$i] * $parms['qty'][$i], 0, 6, $transaction_id, "purchase", $account_type, $parms['warehouse_id'][$i]);
                        }

                        if (strtolower($parms['stock_status'][$i]) == 'out') {
                            $this->saveTransactionDetail($refrence_id, 0, $parms['price'][$i] * $parms['qty'][$i],  6, $transaction_id, "purchase", $account_type, $parms['warehouse_id'][$i]);
                        }
                    }
                }
            }
            \DB::commit();
            return $this->successResponse("", 'Stock Save Successfully!');
        } catch (Exception $e) {
            \DB::rollBack();
            return $this->errorResponse();
        }
    }
}
