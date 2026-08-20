<?php

namespace App\Http\Controllers;

use App\Core\Hash;
use App\Core\Session;
use App\Http\Validation\RegisterValidation;
use App\Models\User;

class AuthController extends Controller
{

    public function showRegister()
    {
        $this->render("Auth/register", [
            "categories" => $this->getCategories()
        ]);
    }

    // Register
    public function register(array $attributes)
    {
        $validate = new RegisterValidation($attributes);
        if (! empty($validate->errors)) {
            $this->render("Auth/register", [
                "categories" => $this->getCategories(),
                "error" => $validate->errors
            ]);
        }
        $user = new User();
        $user->name = $attributes['name'];
        $user->email = $attributes['email'];
        $user->password = Hash::make($attributes['password']);
        $user->save();

        Session::put("user_id", $user->id);
        redirect('/');
    }

    // Login
    public function showLogin()
    {
        $this->render("Auth/login", [
            "categories" => $this->getCategories()
        ]);
    }

    private function getCategories()
    {
        return category()->all();
    }
}
