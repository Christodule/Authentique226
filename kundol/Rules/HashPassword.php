<?php

namespace App\Rules;

use App\Models\Admin\Customer;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class HashPassword implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $user = Customer::find(\Auth::id());
        if(Hash::check($value,$user->password)){
            return true;
        }
        if($value == "" || $value == null){
            return false;
        }

        return false;

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The Current Password is invalid';
    }
}
