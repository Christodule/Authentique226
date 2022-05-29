<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin\Account;
use App\Models\Admin\Supplier;
use App\Services\Admin\AccountService;

class SupplierTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Supplier::where('id', '>', '0')->delete();
        $supplier = Supplier::create([
            "first_name" => 'Default',
            "last_name" => 'Supplier',
            'address' => "New York, USA",
            'phone' => "0123456789",
            'mobile' => "0123456789",
            'country_id' => "223",
            'state_id' => "43",
            'city' => "New York"
        ]);
        $accounts = new AccountService;
        $accounts->createAccount('vendor','Default Supplier',$supplier->id,'supplier');
    }
}
