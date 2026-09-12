<?php

namespace App\Http\Validation;

use App\Core\Validation;

class RegisterValidation extends Validation
{

    public function __construct(private array $attributes)
    {

        //Name
        if (! $this->textValidate($attributes['name'])) {
            $this->errors['name'] = "Name is not Valid";
        }

        //Email
        if (! $this->textValidate($attributes["email"])) {
            $this->errors['email'] = "Email is not Valid";
        } elseif (! $this->isCorrectEmailFormatting($attributes["email"])) {
            $this->errors['email'] = "please enter correct formatting email";
        }
        if( $this->isEmailExists($attributes['email'])){
            $this->errors['email'] = "this email is exists..!";
        }
    

        //Password
        if (! $this->textValidate($attributes['password'], 10)) {
            $this->errors['password'] = "Password is not Valid, password must be greater than or equal 10 numbers";
        }

        if (! empty($attributes['password'] && empty($attributes['password_confirmation']))) {
            $this->errors["password_confirmation"] = "please enter password confirmation";
        } elseif (! empty($attributes['password_confirmation']) && empty($attributes['password'])) {
            $this->errors['password_confirmation'] = "Please enter your password in the password field above.";
        } elseif ($attributes['password'] != $attributes["password_confirmation"]) {
            $this->errors["password_confirmation"] =  "The passwords do not match";
        }
    }
}
