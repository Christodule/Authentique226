<?php

namespace App\Repository\Admin;

use App\Contract\Admin\SaleQuotationInterface;
use App\Http\Resources\Admin\SaleQuotation as SaleQuotationResource;
use App\Models\Admin\Account;
use App\Models\Admin\DefaultAccount;
use App\Models\Admin\Language;
use App\Models\Admin\SaleQuotation;
use App\Models\Admin\Transaction;
use App\Models\Admin\TransactionDetail;
use App\Services\Admin\SaleQuotationService;
use App\Traits\ApiResponser;
use DB;
use Illuminate\Support\Collection;

class SaleQuotationRepository implements SaleQuotationInterface
{
    use ApiResponser;
    /**
     * @return Collection
     */
    public function all()
    {
        try {
            $SaleQuotation = new SaleQuotation;
            if (isset($_GET['getDetail']) && $_GET['getDetail'] == '1') {
                $SaleQuotation = $SaleQuotation->with('detail');
            }
            $languageId = Language::defaultLanguage()->value('id');
            if (isset($_GET['language_id']) && $_GET['language_id'] != '') {
                $language = Language::languageId($_GET['language_id'])->firstOrFail();
                $languageId = $language->id;
            }
            if (isset($_GET['getProduct']) && $_GET['getProduct'] == '1') {
                $SaleQuotation = $SaleQuotation->with('detail.product.detail', function ($querys) use ($languageId) {
                    $querys->where('language_id', $languageId);
                });
            }
            if (isset($_GET['getProductCombination']) && $_GET['getProductCombination'] == '1') {
                $SaleQuotation = $SaleQuotation->with('detail.product_combination');
            }
            if (isset($_GET['limit']) && is_numeric($_GET['limit']) && $_GET['limit'] > 0) {
                $numOfResult = $_GET['limit'];
            } else {
                $numOfResult = 100;
            }
            $sortBy = ['id', 'payable','amount_paid','discount','due_amount'];
            $sortType = ['ASC', 'DESC', 'asc', 'desc'];
            if (isset($_GET['sortBy']) && $_GET['sortBy'] != '' && isset($_GET['sortType']) && $_GET['sortType'] != '' && in_array($_GET['sortBy'], $sortBy) && in_array($_GET['sortType'], $sortType)) {
                $SaleQuotation = $SaleQuotation->orderBy($_GET['sortBy'], $_GET['sortType']);
            }
            return $this->successResponse(SaleQuotationResource::collection($SaleQuotation->paginate($numOfResult)), 'Data Get Successfully!');
        } catch (Exception $e) {
            return $this->errorResponse();
        }
    }

    public function show($SaleQuotation)
    {
        try {
            $SaleQuotation = SaleQuotation::SaleQuotationId($SaleQuotation->id);
            if (isset($_GET['getDetail']) && $_GET['getDetail'] == '1') {
                $SaleQuotation = $SaleQuotation->with('detail');
            }
            $languageId = Language::defaultLanguage()->value('id');
            if (isset($_GET['language_id']) && $_GET['language_id'] != '') {
                $language = Language::languageId($_GET['language_id'])->firstOrFail();
                $languageId = $language->id;
            }
            if (isset($_GET['getProduct']) && $_GET['getProduct'] == '1') {
                $SaleQuotation = $SaleQuotation->with('detail.product.detail', function ($querys) use ($languageId) {
                    $querys->where('language_id', $languageId);
                });
            }
            if (isset($_GET['getProductCombination']) && $_GET['getProductCombination'] == '1') {
                $SaleQuotation = $SaleQuotation->with('detail.product_combination');
            }

            return $this->successResponse(new SaleQuotationResource($SaleQuotation->firstOrFail()), 'Data Get Successfully!');
        } catch (Exception $e) {
            return $this->errorResponse();
        }
    }

    public function store(array $parms)
    {
        DB::beginTransaction();
        try {
            $sql = new SaleQuotation;
            $parms['created_by'] = \Auth::id();
            $sql = $sql->create($parms);
        } catch (Exception $e) {
            return $this->errorResponse();
        }
        if ($sql) {

            $SaleQuotationService = new SaleQuotationService;
            $variable_result = $SaleQuotationService->SaleQuotationDetailData($parms, $sql->id, 'store', $sql->warehouse_id);
        } else {
            return $this->errorResponse();
        }

        if ($sql) {
            $default_account = DefaultAccount::pluck('account_id', 'type')->toArray();
            $account_id = Account::where('type', 'customer')->where('reference_id', $parms['customer_id'])->value('id');
            if (!$account_id) {
                $account_id = $default_account['customer'];
            }
            $inc = Transaction::latest()->value('transaction_number');
            $inc = intVal($inc);
            $inc++;
            $trans_id = Transaction::create([
                'transaction_number' => $inc,
                'transaction_date' => date('Y-m-d'),
                'description' => 'SaleQuotation item',
            ]);
            TransactionDetail::create([
                'transaction_id' => $trans_id->id,
                'account_id' => $account_id,
                'reference_id' => $sql->id,
                'user_id' => $parms['customer_id'],
                'type' => 'SaleQuotation',
                'dr_amount' => '0',
                'cr_amount' => $sql->amount_paid,
            ]);
            TransactionDetail::create([
                'transaction_id' => $trans_id->id,
                'account_id' => $default_account['cash'],
                'reference_id' => $sql->id,
                'user_id' => $parms['customer_id'],
                'type' => 'cash',
                'dr_amount' => $sql->amount_paid,
                'cr_amount' => '0',
            ]);

            DB::commit();
            return $this->successResponse(new SaleQuotationResource($sql), 'SaleQuotation Save Successfully!');
        } else {
            return $this->errorResponse();
        }
    }

    public function update(array $parms, $SaleQuotation)
    {

        try {
            $parms['updated_by'] = \Auth::id();
            $SaleQuotation->update($parms);
        } catch (Exception $e) {
            return $this->errorResponse();
        }
        if ($SaleQuotation) {
            return $this->successResponse(new SaleQuotationResource($SaleQuotation), 'SaleQuotation Update Successfully!');
        } else {
            return $this->errorResponse();
        }
    }

    public function destroy($SaleQuotation)
    {
        try {
            $sql = SaleQuotation::findOrFail($SaleQuotation);
            $sql->delete();
        } catch (Exception $e) {
            return $this->errorResponse();
        }

        if ($sql) {
            return $this->successResponse('', 'SaleQuotation Delete Successfully!');
        } else {
            return $this->errorResponse();
        }
    }
}
