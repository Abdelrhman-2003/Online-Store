# Online Store

A simple **E-commerce** application built with **PHP** and **MySQL** using a custom **MVC architecture**. This project was created as a learning experience to understand how modern web applications work behind the scenes without relying on frameworks.

The application demonstrates core backend concepts such as routing, controllers, views, database interaction, and CRUD operations while following clean code practices and object-oriented programming principles.

---

## Features

* Product Management (CRUD)
* Category Management
* Product Colors
* Product Sizes
* Database Relationships
* Custom MVC Architecture
* Custom Router
* PDO Database Connection
* PSR-4 Autoloading
* Object-Oriented PHP

---

## Technologies Used

* PHP 8+
* MySQL
* HTML5
* Tailwind CSS
* MVC Architecture
* PDO
* Composer Autoloading (PSR-4)

---

## Requirements

Before running the project, make sure the following software is installed:

* PHP **8.0** or higher
* MySQL **5.7+** or MariaDB **10.3+**
* Git
* PHP Built-in Web Server

Optional:

* phpMyAdmin
* MySQL Workbench
* Laragon / XAMPP

---

## Installation

### 1. Clone the Repository

```bash
git clone https://github.com/Abdelrhman-2003/Online-Store.git

cd Online-Store
```

---

### 2. Install Composer Dependencies

Install the project dependencies and generate the Composer autoloader:

```bash
composer install
```
---
 

### 3. Create the Database

Create a new database named:

```sql
CREATE DATABASE online_store;
```

---

## Create the Database Tables

Run the following SQL statements to create the required tables for the project. These tables define the database structure for storing categories and products.

```sql
CREATE TABLE Categories (
    id INT PRIMARY KEY AUTO_INCREMENT,
    categoryName VARCHAR(255) NOT NULL,
    categoryDescription TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE Products (
    id INT PRIMARY KEY AUTO_INCREMENT,
    productName VARCHAR(255) NOT NULL,
    productDescription TEXT,
    price DECIMAL(10, 2) NOT NULL,
    category_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES Categories(id)
);
```

---

### 4. Configure the Database

Open:

```text
src/config/database.php
```

Update your database credentials.

Example:

```php
return [
    "default" => "mysql",

    "connections" => [
        "mysql" => [

            "dbname"   => "online_store",
            "host"     => "localhost",
            "port"     => 3306,
            "username" => "root",
            "password" => ""

        ]
    ]
];
```
---

### 5. Verify PHP Installation

Run:

```bash
php -v
```

You should see PHP **8.0** or later.

---

### 6. Start the Development Server

```bash
php -S localhost:8000 -t Public/
```

Open your browser:

```
http://localhost:8000
```

If everything is configured correctly, the application should load successfully.

---

## Database Migrations

In addition to creating the tables manually with the SQL statements above, this project includes a simple **custom migration system** to manage database schema changes in a structured and version-controlled way. This is especially useful for anyone cloning the project, since new migrations can add tables/columns (like `Colors`, `Sizes`, `Product_Color`, `Product_Size`, etc.) without you having to write the SQL by hand.

### Migration Files Location

All migration files live inside:

```text
src/Database/Migrations/
```

Each migration file contains a class with two methods:

* `up()` — defines what happens when the migration runs (e.g. creating/altering a table).
* `down()` — defines how to reverse it (e.g. dropping the table/column).

### Running Migrations

All migration commands are executed through the `migrate.php` file in the project root:

```bash
php migrate.php <command> [arguments]
```

#### 1. Create a New Migration

```bash
php migrate.php make <migration_name>
```

Example:

```bash
php migrate.php make create_colors_table
```

This generates a new timestamped migration file inside `src/Database/Migrations/` with an empty `up()` and `down()` method ready to be filled in.

> **Note:** the migration name must start with a lowercase letter or underscore, followed by lowercase letters, numbers, or underscores only (e.g. `create_colors_table`, `add_price_to_products`).

#### 2. Run Migrations

```bash
php migrate.php run
```

This executes all migrations that haven't been applied yet (in order), and records each one in a `migrations` table so it won't run again. If there's nothing new to run, it will simply let you know.

#### 3. Rollback Migrations

```bash
php migrate.php rollback
```

This rolls back the **last batch** of migrations that were executed, by calling each migration's `down()` method.

### How It Works

* The first time you run any migration command, a `migrations` table is created automatically in your database to keep track of which migrations have already run.
* Every time you run `php migrate.php run`, all newly executed migrations are grouped together into a single **batch number**.
* Running `php migrate.php rollback` will undo the migrations from the most recent batch only.

### Quick Example for New Contributors

If you just cloned the project and want to get your database schema fully up to date using migrations instead of manual SQL:

```bash
cd Online-Store

# Make sure your database connection is configured in src/config/database.php

php migrate.php run
```

---

## Database Structure

The application uses a relational MySQL database to organize products, categories, colors, and sizes.

### Categories

Stores all product categories.

| Column              | Description           |
| ------------------- | --------------------- |
| id                  | Primary key           |
| categoryName        | Category name         |
| categoryDescription | Category description  |

---

### Products

Stores the application's products.

| Column             | Description                |
| ------------------ | --------------------------- |
| id                 | Primary key                |
| productName        | Product name               |
| productDescription | Product description        |
| price              | Product price              |
| category_id        | References `categories.id` |

---

### Colors

Stores the available colors.

| Column     | Description           |
| ---------- | --------------------- |
| id         | Primary key           |
| colorName  | Color name            |

---

### Sizes

Stores the available product sizes.

| Column     | Description           |
| ---------- | --------------------- |
| id         | Primary key           |
| sizeName   | Size name             |

---

### Product_Color

A pivot table that represents the many-to-many relationship between products and colors.

---

### Product_Size

A pivot table that represents the many-to-many relationship between products and sizes.

---

### Database Relationships

* One **Category** can contain many **Products**.
* One **Product** belongs to one **Category**.
* One **Product** can have multiple **Colors**.
* One **Color** can belong to multiple **Products**.
* One **Product** can have multiple **Sizes**.
* One **Size** can belong to multiple **Products**.

---

## Project Structure

```text
Online-Store/
│
├── Public/
│   ├── assets/
│   │   └── images/
│   │       ├── Categories/      # Category images
│   │       └── Products/        # Product images
│   └── index.php                # Application entry point (Front Controller)
│
├── src/
│   ├── Core/                    # Core framework classes
│   │   ├── Auth.php
│   │   ├── Database.php
│   │   ├── Function.php
│   │   ├── Hash.php
│   │   ├── Migration.php
│   │   ├── MigrationCreator.php
│   │   ├── MigrationRunner.php
│   │   ├── Model.php
│   │   ├── Router.php
│   │   ├── Session.php
│   │   ├── Validation.php
│   │   └── Exceptions/          # Custom exception classes
│   │
│   ├── Http/
│   │   ├── Controllers/         # Handle incoming HTTP requests
│   │   │   ├── AuthController.php
│   │   │   ├── CategoryController.php
│   │   │   ├── Controller.php
│   │   │   ├── HomeController.php
│   │   │   └── ProductController.php
│   │   └── Validation/          # Request validation classes and rules
│   │       ├── CategoryValidation.php
│   │       ├── ImageValidation.php
│   │       ├── LoginValidation.php
│   │       ├── ProductValidation.php
│   │       └── RegisterValidation.php
│   │
│   ├── Models/                  # Eloquent-style models
│   │   ├── Category.php
│   │   ├── Color.php
│   │   ├── Product.php
│   │   ├── ProductColor.php
│   │   ├── ProductSize.php
│   │   ├── Size.php
│   │   └── User.php
│   │
│   ├── Database/
│   │   └── Migrations/          # Database migration files
│   │
│   ├── Views/
│   │   ├── Partials/            # Reusable view components (head, header, nav)
│   │   └── Template/            # Page templates
│   │       ├── Auth/
│   │       ├── Categories/
│   │       ├── Category/
│   │       ├── Products/
│   │       ├── home.phtml
│   │       └── statusCode.phtml
│   │
│   └── config/
│       ├── database.php         # Database configuration
│       └── routes.php           # Route definitions
│
├── logs/
│   └── error.log                # Application error log
│
├── migrate.php                  # CLI entry point for the migration system
├── composer.json
├── composer.lock
└── README.md                    # Project documentation
```


---

## Running the Application

After completing the installation steps:

1. Start your MySQL server.
2. Start the PHP development server.

```bash
php -S localhost:8000 -t Public/
```

Open your browser and visit:

```
http://localhost:8000
```

The application should now be running.

---

## Quick Start

Every time you want to continue working on the project:

```bash
cd Online-Store

php -S localhost:8000 -t Public/
```

Then open:

```
http://localhost:8000
```

---

## Contributing

Contributions are welcome.

If you'd like to improve the project:

1. Fork the repository.
2. Create a new feature branch.
3. Commit your changes.
4. Push the branch.
5. Open a Pull Request.

Please keep the coding style consistent with the existing project structure.

---

## License

This project was created for learning purposes and is open for educational use.