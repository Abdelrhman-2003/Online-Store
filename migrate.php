<?php
require "src/Core/Function.php";
require "src/Core/Database.php";
require "src/Core/Migration.php";
require "src/Core/Exceptions/QueryException.php";
require "src/Core/MigrationRunner.php";

use App\Core\Exceptions\QueryException;
use App\Core\MigrationRunner;

$command = $argv[1] ?? null;
$fileName = $argv[2] ?? null;

try {
    migCommand($command);
} catch (QueryException $e) {
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
