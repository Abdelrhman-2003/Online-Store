<?php

namespace App\Core;

class MigrationCreator
{
    public function __construct(protected ?string $fileName, protected string $migrationsPath)
    {
        //
    }

    public function make() : void
    {
        $this->handleMakeCommand($this->fileName) ;
        $migrationFile = date("Y_m_d_His") . "_{$this->fileName}";
        $fileName = "src/Database/Migrations/$migrationFile.php";
        $className = resolveClassName($this->fileName);
        $content =  "<?php
        
namespace App\Database\Migrations;

use App\Core\Migration;

class {$className} extends Migration
{
    public function up(): void {}
    public function down(): void {}
}";
        file_put_contents($fileName , $content);    
        exit(0);   
}

    public function migrationFileExists()
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

    public function handleMakeCommand($file)
    {
        if ($file == null) {
            echo "php migrate.php make <migration-name>";
            exit(0);
        } elseif (!preg_match('/^[a-z_][a-z0-9_]*$/', $file)) {
            echo "Invalid Class Name: {$file} \nShould start with a lowercase letter or underscore, followed by lowercase letters, numbers, or underscores only..!";
            exit(1);
        }
        if (! $this->migrationFileExists()) {
            echo "This file exists: {$file}. \nThe Migration File cannot be duplicated again!";
            exit(1);
        }
    }
}
