<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin\Customer;
use App\Models\Admin\Account;
use App\Services\Admin\AccountService;

class CustomerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Customer::where('id', '>', '0')->delete();
        $customer = Customer::create([
            "first_name" => 'default',
            "last_name" => 'pos customer',
            "email" => 'default-pos-customer@email.com',
            "gallary_id" => '1',
            "password" => \Hash::make('123'),
            "is_seen" => '1',
            "password" => 'active'
        ]);

        $accounts = new AccountService;
        $accounts->createAccount('CUSTOMER','default pos customer',$customer->id,'customer');
    }
}
