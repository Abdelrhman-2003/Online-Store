<?php

namespace App\Core;

class MigrationCreator
{
    private string $migrationFileName;
    private string  $contentOfMigrationFile;

    public function __construct(protected ?string $fileName, protected string $migrationsPath)
    {
        //
    }

    public function make(): void
    {
        $this->handleMakeCommand($this->fileName);
        file_put_contents($this->migrationFileName, $this->contentOfMigrationFile);
        exit(0);
    }

    private function migrationFileExists(): bool
    {
        $files = glob($this->migrationsPath . '/*.php');

        foreach ($files as $file) {
            $currentFile = sterilizeTheFileNameOfTheMigration($file);
            if ($currentFile === $this->fileName) {
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
            $migrationFile = date("Y_m_d_His") . "_{$this->fileName}";
            $this->migrationFileName = "src/Database/Migrations/$migrationFile.php";
            $className = resolveClassName($this->fileName);
            $this->contentOfMigrationFile =  "<?php
        
namespace App\Database\Migrations;

use App\Core\Migration;

class {$className} extends Migration
{
    public function up(): void {}
    public function down(): void {}
}";
        }
    }
}
