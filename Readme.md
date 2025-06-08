# PHP MVC Framework

A lightweight, educational MVC (Model-View-Controller) framework built from scratch in PHP. This framework demonstrates core MVC principles and provides a solid foundation for understanding how popular PHP frameworks work under the hood.

## Features

- **MVC Architecture**: Clear separation of concerns with Models, Views, and Controllers
- **Database Abstraction**: Simple CRUD operations with PDO support
- **Template System**: View rendering with layout support
- **Extensible Design**: Easy to extend with additional functionality

## Directory Structure

```
mvc-framework/
├── core/
│   ├── App.php          # Main application router
│   ├── Controller.php   # Base controller class
│   ├── Model.php        # Base model class
│   └── Database.php     # Database connection handler
├── controllers/
│   ├── HomeController.php
│   └── UserController.php
├── models/
│   └── User.php
├── views/
│   ├── layouts/         # Page templates
│   ├── home/           # Home controller views
│   └── users/          # User controller views
├── index.php           # Application entry point
├── .htaccess          # URL rewriting rules
└── README.md
```

## Quick Start

### Method 1: Using XAMPP/WAMP (Recommended)

1. **Install XAMPP**
   - Download from [https://www.apachefriends.org/](https://www.apachefriends.org/)
   - Install and start Apache and MySQL services

2. **Setup Project**
   ```bash
   # Navigate to your web directory
   cd C:\xampp\htdocs\
   
   # Clone or create your project folder
   mkdir mvc-framework
   cd mvc-framework
   ```

3. **Configure Database**
   - Open [http://localhost/phpmyadmin](http://localhost/phpmyadmin)
   - Create database: `mvc_app`
   - Run the SQL setup (see Database Setup section)

4. **Test Installation**
   - Visit [http://localhost/mvc-framework/](http://localhost/mvc-framework/)

### Method 2: PHP Built-in Server

```bash
# Navigate to your project directory
cd /path/to/mvc-framework

# Start the built-in server
php -S localhost:8000

# Visit http://localhost:8000
```

## Database Setup

Create a MySQL database named `mvc_app` and run the following SQL:

```sql
CREATE DATABASE mvc_app;
USE mvc_app;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Sample data
INSERT INTO users (name, email) VALUES 
('John Doe', 'john@example.com'),
('Jane Smith', 'jane@example.com');
```

Update database credentials in `core/Database.php`:

```php
private $host = 'localhost';
private $dbname = 'mvc_app';
private $username = 'root';
private $password = '';
```

## URL Routing

The framework uses clean URLs following this pattern:
```
/controller/method/parameter
```

### Available Routes

| URL | Controller | Method | Description |
|-----|------------|--------|-------------|
| `/` | Home | index | Homepage |
| `/home` | Home | index | Homepage |
| `/home/about` | Home | about | About page |
| `/user` | User | index | List all users |
| `/user/show/1` | User | show | View specific user |
| `/user/create` | User | create | Create new user |
| `/user/edit/1` | User | edit | Edit user |
| `/user/delete/1` | User | delete | Delete user |

## Creating New Components

### Adding a New Controller

```php
<?php
// controllers/ProductController.php

class ProductController extends Controller {
    
    public function index() {
        $productModel = $this->model('Product');
        $products = $productModel->getAll();
        
        $this->view('products/index', [
            'products' => $products
        ]);
    }
    
    public function show($id) {
        $productModel = $this->model('Product');
        $product = $productModel->getById($id);
        
        $this->view('products/show', [
            'product' => $product
        ]);
    }
}
```

### Adding a New Model

```php
<?php
// models/Product.php

class Product extends Model {
    protected $table = 'products';
    
    public function getByCategory($category) {
        $sql = "SELECT * FROM {$this->table} WHERE category = :category";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':category', $category);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
```

### Adding Views

Create view files in the appropriate directory:
```php
<!-- views/products/index.php -->
<h1>Products</h1>
<div class="products-grid">
    <?php foreach($products as $product): ?>
        <div class="product-card">
            <h3><?= htmlspecialchars($product['name']) ?></h3>
            <p><?= htmlspecialchars($product['description']) ?></p>
            <a href="/product/show/<?= $product['id'] ?>">View Details</a>
        </div>
    <?php endforeach; ?>
</div>
```

## Core Classes

### App Class
Handles routing and application initialization. Parses URLs and dispatches to appropriate controllers.

### Controller Class
Base class for all controllers. Provides methods for loading models and rendering views.

### Model Class
Base class for database operations. Includes standard CRUD methods that work with any table.

### Database Class
Manages database connections using PDO with prepared statements for security.

## Configuration

### Environment Setup
Create a `.env` file or modify `core/Database.php` for different environments:

```php
// Development
private $host = 'localhost';
private $dbname = 'mvc_app_dev';

// Production
private $host = 'your-production-host';
private $dbname = 'mvc_app_prod';
```

### Apache Configuration
Ensure your `.htaccess` file is properly configured:

```apache
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php [QSA,L]
```

## Troubleshooting

### Common Issues

1. **404 Errors on all pages except homepage**
   - Enable Apache mod_rewrite
   - Check `.htaccess` file permissions
   - Verify Apache configuration allows .htaccess overrides

2. **Database Connection Errors**
   - Verify MySQL service is running
   - Check database credentials
   - Ensure database exists

3. **PHP Errors**
   - Enable error reporting in development
   - Check PHP error logs
   - Verify PHP version compatibility (requires PHP 7.0+)

### Enable Error Reporting
Add to the top of `index.php` for development:

```php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
```

## Contributing

This is an educational framework designed to demonstrate MVC principles. Feel free to:

- Add new features
- Improve error handling
- Enhance the template system
- Add middleware support
- Implement authentication

## License

This project is open source and available under the [MIT License](LICENSE).

## Learning Resources

- [MVC Architecture Pattern](https://en.wikipedia.org/wiki/Model%E2%80%93view%E2%80%93controller)
- [PHP PDO Documentation](https://www.php.net/manual/en/book.pdo.php)
- [Apache mod_rewrite](https://httpd.apache.org/docs/current/mod/mod_rewrite.html)

---

**Note**: This framework is designed for educational purposes. For production applications, consider using established frameworks like Laravel, Symfony, or CodeIgniter.