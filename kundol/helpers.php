<?php

use App\Models\Admin\AvailableQty;
use App\Models\Admin\Setting;
use App\Models\Admin\CurrentTheme;
use App\Models\Admin\Currency;
use App\Models\Admin\Inventory;
use App\Models\Admin\PaymentMethod;
use App\Models\Admin\PaymentMethodSetting;
use App\Models\Admin\ProductCombination;
use App\Models\Admin\TransactionDetail;
use App\Models\DemoSettings;

if(!function_exists("getSetting")){

    function getSetting(){
        $settings = Setting::whereNotIn('type',['app_general','app_display_in_setting','app_notification_setting','app_login_signup'])->get();
        $normalizdSetting = [];
        foreach($settings as $setting){
            $normalizdSetting[$setting->key] = $setting->value; 
        }

        $demoSettings = DemoSettings::where('ip',\Request::ip())->first();
        if($demoSettings){
            $normalizdSetting['header_style'] = $demoSettings->header_style;
            $normalizdSetting['Footer_style'] = $demoSettings->footer_style;
            $normalizdSetting['slider_style'] = $demoSettings->slider_style;
            $normalizdSetting['banner_style'] = $demoSettings->banner_style;
            $normalizdSetting['card_style'] = $demoSettings->cart_style;
            $normalizdSetting['product_detail'] = $demoSettings->product_page_style;
            $normalizdSetting['shop'] = $demoSettings->shop_style;
            $normalizdSetting['color'] = $demoSettings->color;

        }
        // dd($normalizdSetting);
        return $normalizdSetting;
   }
}   


if(!function_exists("homePageBuilderJson")){

    function homePageBuilderJson(){
        $currentThemeSetting = [];
        if(CurrentTheme::first()){
            $currentThemeSetting = CurrentTheme::first()->home_setting;
            $currentThemeSetting =  json_decode($currentThemeSetting,true);
        }
       
        return $currentThemeSetting;
    }
}


if(!function_exists("currencyConvertor")){

    function currencyConvertor($value){
        $currency = Currency::where('id',1)->first();
        if($currency){
            $calculatedValue = $value*$currency->exchange_rate;

            if($currency == 'left'){
                $currency->code.' '.$calculatedValue;
            }else{
                $calculatedValue.' '.$currency->code;
            }
        }
    }
}


if(!function_exists("PaymentMethods")){

    function PaymentMethods($key){
        $PaymentMethod = PaymentMethodSetting::where('key',$key)->first();
        return $PaymentMethod;
    }
}


if(!function_exists("variationProductTitleBasedOnCombinationId")){

    function variationProductTitleBasedOnCombinationId($id){
        $productVariations = ProductCombination::where('id',$id)->with('combination', 'combination.variation','combination.variation.variation_detail')->first();
        \Log::info($productVariations);
        $title = '(';
        if(isset($productVariations->combination)){
            foreach ($productVariations->combination as $key => $combination) {
                foreach ($combination->variation->variation_detail as $key2 => $variation) {
                    if($variation->language_id == 1){
                            $title .=$variation->name;
                        if($key+1 != count($productVariations->combination))
                            $title .= '-';
                    }
                            
                }
                
            }
        }

        return $title.')';
    }
}



if(!function_exists("averagePriceProductIdBased")){

    function averagePriceProductIdBased($productId = null,$combinationId = null,$warehouse){
        
        
        $average = \DB::table('transaction_detail')
        ->select( \DB::raw('SUM(dr_amount) As dr_sum'), \DB::raw('SUM(cr_amount) AS cr_sum'));
        if($productId != null)
            $average = $average->where('reference_id',$productId);
        if($combinationId != null)
                $average = $average->where('reference_id',$combinationId);
                
        $average = $average->where('warehouse_id',$warehouse);
        $average = $average->where('type','purchase');

        $average = $average->first();
        
        $available_qty = new AvailableQty;
        if($combinationId != null)
                $available_qty = $available_qty->where('product_combination_id',$combinationId);
        if($productId != null)
            $available_qty = $available_qty->where('product_id',$productId);

        $available_qty = $available_qty->where('warehouse_id',$warehouse);
        $available_qty = $available_qty->value('remaining');

        return ($average->dr_sum - $average->cr_sum)/$available_qty;
    }
}