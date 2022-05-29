<?php

namespace App\Services\Admin;

use App\Traits\ApiResponser;
use DB;
use App\Models\Web\Cart;
use App\Models\Admin\Inventory;
use App\Models\Web\OrderDetail;
use App\Services\Admin\AvailableQty;
use Illuminate\Support\Facades\Gate;
use App\Models\Web\CouponOrder;
use App\Models\Admin\CouponSetting;
use App\Models\Admin\PaymentMethodSetting;
use App\Models\Admin\Product;
use App\Models\Admin\Warehouse;
use App\Traits\Transactions;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Auth;

class OrderService
{
    use ApiResponser;
    use Transactions;

    public function CheckStock($customer_id)
    {
        $sql = $this->getCartItemQty($customer_id);
        $totalPrice = 0;
        foreach ($sql as $data) {
            $priceToConsider = $data->discounts > 0 ? $data->discounts : $data->prices;
            if (!Gate::allows('isDigital')) {
                $totalPrice = $totalPrice + ($priceToConsider * $data->qty);
                $qtyValidation = new AvailableQty;
                $qtyValidation = $qtyValidation->availableQty($data->product_id, $data->product_combination_id, $data->qty);
                if (!$qtyValidation) {
                    return $this->errorResponseArray('Out of Stock!', 422, $data);
                }
            } else {

                $totalPrice = $totalPrice + $priceToConsider;
            }
        }
        return $this->successResponseArray($totalPrice, 'Order Save Successfully!');
    }

    public function getCartItemQty($customer_id)
    {
        $sql = Cart::type()->customerId($customer_id)->where('is_order', '0');
        $sql = $sql->availableQtys()->get();
        $sql = $sql->unique();
        return $sql;
    }

    public function orderDetail($sql, $order)
    {
        $transaction_id = $this->saveTransaction("sale product");
        $this->saveTransactionDetail($order->customer_id, $order->order_price, 0, 8, $transaction_id, "sale", 'customer', null);

        $products = $productsPoint = [];
        $income = 0;
        foreach ($sql as $data) {
            $totalPrice = 0;
            if (!Gate::allows('isDigital'))
                $totalPrice = $totalPrice + (($data->prices - $data->discounts) * $data->qty);
            else
                $totalPrice = $totalPrice + (($data->prices - $data->discounts));

            $parms['total'] = $data->discounts > 0 ? $data->discounts : $data->prices;
            $parms['product_price'] = $data->prices;
            $parms['product_discount'] = $data->discounts;
            $parms['product_id'] = $data->product_id;
            $parms['product_combination_id'] = $data->product_combination_id;
            $parms['qty'] = $data->qty;
            $parms['product_tax'] = 0;
            $parms['order_id'] = $order->id;
            $parms['warehouse_id'] = $data->warehouse_id;
            OrderDetail::create($parms);

            $refrence_id = $data->product_combination_id != null ? $data->product_combination_id : $data->product_id;
            $account_type = $data->product_combination_id != null ? 'variable_product' : 'simple_product';
            if ($data->product_combination_id != null) {
                $this->saveTransactionDetail($refrence_id, 0, averagePriceProductIdBased(null, $refrence_id, 1) * $data->qty, 6, $transaction_id, "sale", $account_type, $order->warehouse_id);
                $income += (($data->prices - averagePriceProductIdBased(null, $refrence_id, 1)) * $data->qty);
            } else {
                $this->saveTransactionDetail($refrence_id, 0, averagePriceProductIdBased($refrence_id, null, 1) * $data->qty, 6, $transaction_id, "sale", $account_type, $order->warehouse_id);
                $income += (($data->prices - averagePriceProductIdBased($refrence_id, null, 1)) * $data->qty);
            }
            $products[] = $parms['product_price'] * $parms['qty'];
            $productsPoint[] = Product::productId($parms['product_id'])->value('is_points');
            if (!Gate::allows('isDigital'))
                $this->RemoveOrderInventory($parms);
        }

        \Log::info($order->total_tax);
        $this->saveTransactionDetail(14, 0, $income, 14, $transaction_id, "sale", 'income');
        if (isset($order->total_tax) && $order->total_tax > 0)
            $this->saveTransactionDetail(1, 0, $order->total_tax, 10, $transaction_id, "sale", 'tax');

        $points = new PointService;
        $points->orderPoints($products, $productsPoint, $order->customer_id, $order->id);
        $this->RemoveCartItem($order->customer_id);
        return 1;
    }

    public function RemoveOrderInventory($parms)
    {
        $defaultWareHouse =  Warehouse::isDefault()->value('id');
        $parms['warehouse_id'] = $defaultWareHouse;
        $parms['stock_status'] = 'OUT';
        $parms['stock_type'] = 'Order';
        // $parms['created_by'] = Auth::id();
        $parms['reference_id'] = $parms['order_id'];
        $inventory = new Inventory;
        $inventory->unsetEventDispatcher();
        $inventory = $inventory->create($parms);
    }


    public function RemoveCartItem($customer_id)
    {
        Cart::type()->where('customer_id', $customer_id)->update(['is_order' => '1']);
    }


    public function CartItemValidation($params)
    {
        $customer =  Auth::id();
        if (isset($params['customer_id']))
            $customer = $params['customer_id'];
        return Cart::type()->where('customer_id', $customer)->where('is_order', '0')->count();
    }


    public function CouponCodeValidation($coupon_code, $customer_id, $auth_check)
    {
        if ($auth_check) {
            $num_of_usage = CouponOrder::customer($customer_id)->coupon($coupon_code)->value('num_of_usage');
        } else {
            $num_of_usage = 0;
        }

        $sql = CouponSetting::where('code', $coupon_code)->where('expiry_date', '>=', date('Y-m-d'))->first();
        if (!$sql) {
            return $this->errorResponseArray('Coupon Code is Expired!');
        }
        if (intval($sql->usage_limit_per_user) <= intval($num_of_usage)) {
            return $this->errorResponseArray('User Usage Lmit Exceed!');
        }
        if (intval($sql->usage_limit_per_coupon) <= intval($num_of_usage)) {
            return $this->errorResponseArray('Coupon Usage Lmit Exceed!');
        }
        return $this->successResponseArray($sql, 'Coupon Varified!');
    }


    public function paymentMethod($payment_method, $cc_number, $cc_month, $cc_year, $cc_cvc, $amount)
    {
        if ($payment_method == 'stripe') {
            $payment = PaymentMethodSetting::where('payment_method_id', 2)->get();
            $stripe = Stripe::setApiKey(isset($payment[0]->value) ? $payment[0]->value : '');
            try {
                $token = $stripe->tokens()->create([
                    'card' => [
                        'number' => $cc_number,
                        'exp_month' => $cc_month,
                        'exp_year' => $cc_year,
                        'cvc' => $cc_cvc,
                    ],
                ]);
                if (!isset($token['id'])) {
                    return $this->errorResponseArray('Some credential are not correct!');
                }
                $charge = $stripe->charges()->create([
                    'card' => $token['id'],
                    'currency' => 'USD',
                    'amount' => $amount,
                    'description' => 'wallet',
                ]);

                if ($charge['status'] == 'succeeded') {
                    return $this->successResponseArray('', 'Success');
                } else {
                    return $this->errorResponseArray('Money not add in wallet!!');
                }
            } catch (Exception $e) {
                return $this->errorResponseArray($e);
            }
        }
    }




    public function revertOrderProductsQuantity($order)
    {




        $orderDetail = OrderDetail::where('order_id', $order->id)->get();
        $transaction_id = $this->saveTransaction("sale product");
        $this->saveTransactionDetail($order->customer_id,0,$order->order_price, 8, $transaction_id, "sale", 'customer', null);
        $income = 0;
        foreach ($orderDetail as $orderdtl) {
            Inventory::insertOrIgnore([
                'product_id' => $orderdtl->product_id,
                'product_combination_id' => $orderdtl->product_combination_id,
                'warehouse_id' => '1',
                'stock_status' => 'OUT',
                'qty' => $orderdtl->qty,
                'reference_id' => $order->id,
                'stock_type' => 'SaleReturn',
                'updated_by' => \Auth::id(),
                'updated_at' => \Carbon\Carbon::now(),

            ]);

            $refrence_id = $orderdtl->product_combination_id != null ? $orderdtl->product_combination_id : $orderdtl->product_id;
            $account_type = $orderdtl->product_combination_id != null ? 'variable_product' : 'simple_product';
            
            if ($orderdtl->product_combination_id != null) {
                $this->saveTransactionDetail($refrence_id, averagePriceProductIdBased($refrence_id, null, 1) * $orderdtl->qty,0, 6, $transaction_id, "sale", $account_type, $order->warehouse_id);
                $income += (($orderdtl->prices - averagePriceProductIdBased(null, $refrence_id, 1)) * $orderdtl->qty);
            } else {
                $this->saveTransactionDetail($refrence_id, averagePriceProductIdBased($refrence_id, null, 1) * $orderdtl->qty,0, 6, $transaction_id, "sale", $account_type, $order->warehouse_id);
                $income += (($orderdtl->prices - averagePriceProductIdBased($refrence_id, null, 1)) * $orderdtl->qty);
            }

            $this->saveTransactionDetail(14, $income,0,14, $transaction_id, "sale", 'income');
            if (isset($order->total_tax) && $order->total_tax > 0)
                $this->saveTransactionDetail(1,$order->total_tax,0 , 10, $transaction_id, "sale", 'tax');
        }
    }
}
