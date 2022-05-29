<?php

namespace Database\Seeders;

use App\Models\Admin\Tax;
use App\Services\Admin\AccountService;
use Illuminate\Database\Seeder;

class TaxTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tax::where('id', '>', '0')->delete();
        $tax = Tax::create([
            'title' => 'GST',
            'description' => 'GST',
            'created_by' => 1,
        ]
        );
        $accounts = new AccountService;
        $accounts->createAccount('accountpayable','GST', $tax->id,'tax');

    }
}
