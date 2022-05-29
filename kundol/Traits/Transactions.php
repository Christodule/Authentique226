<?php

namespace App\Traits;

use App\Models\Admin\Account;
use App\Models\Admin\Transaction;
use App\Models\Admin\TransactionDetail;

trait Transactions
{

    protected function saveTransaction($description)
    {
        $inc = Transaction::latest()->value('transaction_number');
        $inc = intVal($inc);
        $inc++;
        $trans_id = Transaction::create([
            'transaction_number' => $inc,
            'transaction_date' => date('Y-m-d'),
            'description' => $description,
        ]);
        return $trans_id->id;
    }

    public function saveTransactionDetail($refrence_id, $db_amount, $credit_amount, $parent_id, $trans_id, $type, $account_type,$warehouse = null)
    {

        $account_id = Account::where('type', $account_type)->where('reference_id', $refrence_id)->where('parent_id', $parent_id)->value('id');
        TransactionDetail::create([
            'transaction_id' => $trans_id,
            'account_id' => $account_id,
            'reference_id' => $refrence_id,
            'warehouse_id' => $warehouse,
            'type' => $type,
            'user_id' => \Auth::id(),
            'dr_amount' => $db_amount,
            'cr_amount' => $credit_amount,
        ]);
    }
}
