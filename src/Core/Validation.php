<?php

namespace App\Core;

use App\Core\Exceptions\FileNotFoundException;
use App\Models\User;

abstract class Validation
{
    protected $method;
    public $errors = [];

    public function __construct(private array $attributes)
    {
        //
    }

    protected function isCorrectEmailFormatting(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public function isEmailExists(string $email)
    {
        return User::findByEmail($email);
    }

    protected function textValidate(string $value, int $min = 1, int $max = 100): bool
    {
        $value = trim($value);
        $value = stripslashes($value);
        return strlen($value) >= $min && strlen($value) <= $max;
    }

    protected function isNumeric(string $number): bool
    {
        return (is_numeric($number)) ? true : false;
    }

    protected function isNotEmptyArray(?array $array)
    {
        return (!is_array($array) || empty($array)) ? false : true;
    }

    protected function isFoundImage($image)
    {
        return ($image['image']['name'] === "") ? false : true;
    }

    protected function isCorrectImage($imgTmp)
    {

        return (getImageSize($imgTmp) === false) ? false : true;
    }

    protected function isSizeImage($imgSize, $maxSize = 5242880)
    {
        return ($imgSize >  $maxSize) ? false : true;
    }

    protected function fileExists($imgPath)
    {
        if (! file_exists($imgPath)) {
            throw new FileNotFoundException("File of Image Not Found!");
        }
    }
}
