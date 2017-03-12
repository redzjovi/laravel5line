<?php
namespace App\Validators;

use Illuminate\Support\Facades\Auth;

class CustomValidator
{
    public function checkLogin($attribute, $value, $parameters, $validator)
    {
        $email = array_get($validator->getData(), $parameters[0], null);
        $password = array_get($validator->getData(), $parameters[1], null);

        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            return true;
        } else {
            return false;
        }
    }
}