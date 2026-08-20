<?php

namespace App\Http\Validation;

use App\Core\Hash;
use App\Core\Session;
use App\Core\Validation;
use App\Models\User;
use Override;

class LoginValidation extends Validation
{

    public function __construct(array $attributes)
    {
        if (
            ! $this->textValidate($attributes["email"]) ||
            ! $this->textValidate($attributes['password']) ||
            ! $this->validUserLogin($attributes['email'], $attributes['password'])
        ) {
            $this->errors['email'] = "invalid credentials";
        }
    }

    public function validUserLogin(string $email, string $password)
    {
        $user = User::findByEmail($email);
        if (! $user) {
            return false;
        }

        $isUser = Hash::check($password, $user->password);
        if (! $isUser) {
            return false;
        }
        Session::put("user_id", $user->id);
        return true;
    }
}
