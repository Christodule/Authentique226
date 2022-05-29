<?php

namespace Database\Seeders;

use App\Models\Admin\DefaultAccount;
use Illuminate\Database\Seeder;

class DefaultAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DefaultAccount::where('id', '>', '0')->delete();
        DefaultAccount::insertOrIgnore(
            [
                'id' => '1',
                'account_id' => 8,
                'type' => 'customer',
            ]
        );
        DefaultAccount::insertOrIgnore(
            [
                'id' => '2',
                'account_id' => 11,
                'type' => 'vendor',
            ]
        );

        

        DefaultAccount::insertOrIgnore(
            [
                'id' => '3',
                'account_id' => 6,
                'type' => 'supplies',
            ]
        );

        DefaultAccount::insertOrIgnore(
            [
                'id' => '4',
                'account_id' => 2,
                'type' => 'cash',
            ]
        );


        DefaultAccount::insertOrIgnore(
            [
                'id' => '5',
                'account_id' => 10,
                'type' => 'accountpayable',
            ]
        );

        DefaultAccount::insertOrIgnore(
            [
                'id' => '6',
                'account_id' => 14,
                'type' => 'income',
            ]
        );

        

    }
}
