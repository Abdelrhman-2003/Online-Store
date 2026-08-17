<?php
require "src/Core/Function.php";
require "src/Core/Database.php";
require "src/Core/Migration.php";
require "src/Core/Exceptions/QueryException.php";
require "src/Core/Exceptions/DirectoryNotFoundException.php";
require "src/Core/Exceptions/FileNotFoundException.php";
require "src/Core/MigrationRunner.php";
require "src/Core/MigrationCreator.php";

$command = $argv[1] ?? null;
$argTwo = $argv[2] ?? null;

errorHandlingAtMigrateFile($command , $argTwo);
