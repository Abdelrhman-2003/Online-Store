<?php

namespace App\Core;

use App\Core\Exceptions\DirectoryNotFoundException;

class MigrationCreator
{
    private string $migrationFilePath;
    private string  $contentOfMigrationFile;

    public function __construct(protected ?string $migrationName, protected string $migrationsPath)
    {
        //
    }

    public function make(): void
    {
        $this->handleMakeCommand($this->migrationName);
        file_put_contents($this->migrationFilePath, $this->contentOfMigrationFile);
        exit(0);
    }

    private function migrationFileExists(): bool
    {
        if (! is_dir($this->migrationsPath)) {
            throw new DirectoryNotFoundException("Directory Of Migration Path Not Found..!");
        }
        $files = glob($this->migrationsPath . '/*.php');

        foreach ($files as $file) {
            $currentFile = sterilizeMigrationFileName($file);
            if ($currentFile === $this->migrationName) {
                return false;
            }
        }
        return true;
    }

    private function handleMakeCommand(?string $file): void
    {
        if ($file == null) {
            echo "php migrate.php make <migration-name>";
            exit(0);
        } elseif (!preg_match('/^[a-z_][a-z0-9_]*$/', $file)) {
            echo "Invalid Class Name: {$file} \nShould start with a lowercase letter or underscore, followed by lowercase letters, numbers, or underscores only..!";
            exit(1);
        } elseif (! $this->migrationFileExists()) {
            echo "This file exists: {$file}. \nThe Migration File cannot be duplicated again!";
            exit(1);
        } else {
            $migrationFileName = date("Y_m_d_His") . "_{$this->migrationName}";
            $this->migrationFilePath = $this->migrationsPath . "/" . $migrationFileName . ".php";
            $className = resolveClassName($this->migrationName);
            $this->contentOfMigrationFile =  <<<PHP
<?php
        
namespace App\Database\Migrations;

use App\Core\Migration;

class {$className} extends Migration
{
    public function up(): void {}
    public function down(): void {}
}
PHP;

            echo "Migration File: $file is added Successfully To Migrations Directory";
        }
    }
}
