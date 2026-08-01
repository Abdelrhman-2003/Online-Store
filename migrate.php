<?php
require "src/Core/Function.php";
require "src/Core/Database.php";
require "src/Core/Migration.php";
require "src/Core/Exceptions/QueryException.php";
require "src/Core/Exceptions/DirectoryNotFoundException.php";
require "src/Core/MigrationRunner.php";
require "src/Core/MigrationCreator.php";

use App\Core\Exceptions\QueryException;

$command = $argv[1] ?? null;
$argTwo = $argv[2] ?? null;

try {
    migCommand($command, $argTwo);
} catch (QueryException $e) {
    errorLog($e->getMessage(), $e->getFile(), $e->getLine());
    echo "error is found, Check error.log";
    exit(1);
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
