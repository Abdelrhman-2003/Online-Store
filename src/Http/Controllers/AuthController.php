<?php

namespace App\Http\Controllers;

class AuthController extends Controller{

    public function showRegister(){
        $this->render("Auth/register" , [
            "categories" => $this->getCategories()
        ]);
    }

    public function register(){

    }

        private function getCategories()
    {
        return category()->all();
    }
}