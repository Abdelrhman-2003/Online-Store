<?php

use App\Core\Database;
use App\Core\Exceptions\FileNotFoundException;
use App\Core\MigrationCreator;
use App\Core\MigrationRunner;
use App\Core\Session;
use App\Http\Validation\ImageValidation;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductSize;
use App\Models\Size;

function dd($value)
{
    echo "<pre>";
    var_dump($value);
    echo "</pre>";
    die();
}

function stringToArray(string $seprator, string $string)
{
    return explode($seprator, $string);
}

function base_path(string $path)
{
    return __DIR__ . '/../' . $path;
}

function view(string $path, array $attributes = [])
{
    extract($attributes);
    require base_path("Views/Template/{$path}.phtml");
}

function abort(int $code, string $message)
{
    http_response_code($code);

    view(
        "statusCode",
        [
            "message" => $message,
            "code" => $code
        ]
    );
    die();
}

function redirect($path, $code = 200)
{
    http_response_code($code);
    header("Location: {$path}");
    die();
}

function errorLog($error, $file, $line)
{
    error_log(
        "[Time] " . date('Y-m-d H:i:s') .  " | " .
            "[Error] " . $error .  " | " .
            "[File] " . $file .  " | " .
            "[Line] " . $line .   "\n",
        3,
        __DIR__ . "/../../logs/error.log"
    );
}

function serverError($error, $file, $line)
{
    errorLog($error, $file, $line);
    abort(500, "Something went wrong, please try again later");
}

function db()
{
    static $database = null;
    if ($database === null) {
        $config = require base_path("./config/database.php");
        $database = new Database($config['connections'][$config['default']]);
    }
    return $database;
}


function checkColor($category)
{
    return ($category === "Clothies-Category" || $category === "Technology-Category") ? true : false;
}

function checkSize($category)
{
    return ($category === "Clothies-Category") ? true : false;
}

function checkImage($newImage, $oldImage)
{
    if ($newImage['image']['name'] === "") {
        $extension = pathinfo($oldImage, PATHINFO_EXTENSION);
    } else {

        $extension = pathinfo($newImage['image']['name'], PATHINFO_EXTENSION);
    }
    return $extension;
}

function moveUploadedFile($fileName, $destination)
{
    return move_uploaded_file($fileName, $destination);
}

function checkTypeOfImage($imgTmp)
{
    $imgType = mime_content_type($imgTmp);
    [, $extension] = explode("/", $imgType);
    return (strtolower($extension) === "png" ||
        strtolower($extension) === "jpg" ||
        strtolower($extension) === "jpeg")  ? true : false;
}

function autoloaderFileNotFound($file)
{
    if (! file_exists($file)) throw new FileNotFoundException("Autoloader error: Class file not found: {$file}");
}

function classNameToFileName($class)
{
    $class = str_replace("\\", "/", $class);
    $class = str_replace("App/", "", $class);
    return $class;
}

function splAutoLoaderHandle($class)
{
    if (strpos($class, "App\\") !== 0) {
        return;
    }
    $class = classNameToFileName($class);
    $file = base_path("{$class}.php");
    try {
        autoloaderFileNotFound($file);
    } catch (RuntimeException $e) {
        serverError($e->getMessage(), $e->getFile(), $e->getLine());
    }
    require $file;
}

function imageValidation()
{
    static $image = null;
    if ($image === null) {
        $image = new ImageValidation();
    }
    return $image;
}

function migCommand(?string $command, $argTwo = null)
{
    $runner = new MigrationRunner("src/Database/Migrations");

    switch ($command) {
        case "run":
            $runner->run();
            break;

        case "rollback":
            $runner->rollBack();
            break;

        case "make":
            (new MigrationCreator($argTwo, "src/Database/Migrations"))->make();
            break;

        case null:
            echo "Usage:
     command [arguments]

Available Commands:
   run          Migrates new database upgrades
   rollback     Rollbacks the last migration";
            break;

        default:
            echo "Unknown Command : {$command}";
            exit(1);
    }
}

function resolveClassName(string $migrationName): string
{
    $withoutTimestamp = preg_replace('/^\d{4}_\d{2}_\d{2}_\d{6}_/', '', $migrationName);
    $words = explode('_', $withoutTimestamp);
    $words = array_map('ucfirst', $words);
    return implode('', $words);
}

function sterilizeMigrationFileName(string $file): string
{
    $file = basename($file, ".php");
    $file = explode("_", $file);
    $file = array_slice($file, 4, count($file) - 1);
    return implode("_", $file);
}

function errorHandlingAtMigrateFile(string $command, ?string $argTwo)
{
    try {
        migCommand($command, $argTwo);
        exit(0);
    } catch (RuntimeException $e) {
        errorLog($e->getMessage(), $e->getFile(), $e->getLine());
        echo "error is found, Check error.log";
        exit(1);
    } catch (Exception $e) {
        errorLog($e->getMessage(), $e->getFile(), $e->getLine());
        echo "error is found, Check error.log";
        exit(1);
    } finally {
        db()->disConnect();
    }
}

function category()
{
    static $category = null;
    if ($category === null) {
        $category = new Category;
    }
    return $category;
}

function product()
{
    static $product = null;
    if ($product === null) {
        $product = new Product;
    }
    return $product;
}

function size()
{
    static $size = null;
    if ($size === null) {
        $size = new Size;
    }
    return $size;
}

function color()
{
    static $color = null;
    if ($color === null) {
        $color = new Color;
    }
    return $color;
}

function productColor()
{
    static $productColor = null;
    if ($productColor == null) {
        $productColor = new ProductColor();
    }
    return $productColor;
}

function productSize()
{
    static $productSize = null;
    if ($productSize == null) {
        $productSize = new ProductSize();
    }
    return $productSize;
}

function destorySessionForLoginUser()
{
    Session::unset("user_id");
    session_destroy();
    redirect('/login');
}
