<?php

namespace Database\Seeders;

use App\Models\Admin\Warehouse;
use App\Models\Admin\Purchaser;
use App\Models\Admin\UserWarehouse;
use App\Models\User;
use Illuminate\Database\Seeder;

class WarehouseTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        //Warehouse::where('id', '>', '0')->delete();
        Warehouse::insertOrIgnore([
            'code' => '0101',
            'name' => 'Default Warehouse',
            'address' => 'New York, USA',
            'phone' => '0123456789',
            'email' => 'default@email.com',
            'is_default' => "1",
            'state_id' => "1822",
            'country_id' => "1",

        ]);

        Purchaser::where('id', '>', '0')->delete();
        Purchaser::insertOrIgnore([
            "first_name" => 'Default',
            "last_name" => 'Purchaser',
            'address' => "New York, USA",
            'phone' => "0123456789",
            'mobile' => "0123456789",
            'country_id' => "223",
            'state_id' => "43",
            'city' => "New York"
        ]);

        UserWarehouse::where('id', '>', '0')->delete();
        $users = User::all();
        foreach($users as $user){
            UserWarehouse::insert([
                "user_id" =>$user->id,
                "warehouse_id" => 1,
            ]);
        }
        
    }
}