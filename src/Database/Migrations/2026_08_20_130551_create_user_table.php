<?php

namespace App\Database\Migrations;

use App\Core\Migration;

class CreateUserTable extends Migration
{
    public function up(): void
    {
        db()->execute("CREATE TABLE users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL 
    )");
    }

    public function down(): void {
        db()->execute("DROP TABLE IF EXISTS users;");
    }
}
