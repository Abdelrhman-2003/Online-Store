<?php
require "vendor/autoload.php";

$command = $argv[1] ?? null;
$argTwo = $argv[2] ?? null;

$result = errorHandlingAtMigrateFile($command, $argTwo);
if ($result) {
    exit(0);
}
exit(1);
