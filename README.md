# POC 02 — Laravel Full-Stack E-Commerce Application

This is a complete, fully functional Proof of Concept Laravel 11 E-Commerce Module built exactly to the specifications provided. It includes a public store, a session-based cart, a customer area, and an admin panel with role-based route protection.

## Features Included
- **Public Store**: Home page, paginated product catalogue, category filtering, search, and product details.
- **Cart & Checkout**: Session-based cart, robust checkout process using database transactions to prevent stock overselling.
- **Authentication**: Laravel Breeze (Blade) setup with role management (`admin` vs `customer`).
- **Customer Dashboard**: Order history and profile management.
- **Admin Panel**: Dedicated dashboard, full CRUD for products and categories (with image upload via Storage facade), and order management (update statuses).
- **Design**: Clean, responsive UI built with Bootstrap 5.

## Installation Instructions

Follow these exact steps to run the application locally on Windows (XAMPP).

1. **Start XAMPP**: Open XAMPP Control Panel and start **Apache** and **MySQL**.
2. **Create Database**: Open phpMyAdmin (or any MySQL client) and create a database named `ecommerce_poc`. (Or use the CLI: `mysql -u root -e "CREATE DATABASE ecommerce_poc;"`)
3. **Run Setup Commands**: Open a terminal in the root of this project (`c:/Users/achyu/Desktop/E-Commerce`) and run:

```bash
composer install
npm install
npm run build
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
php artisan serve
```

## Test Credentials

**Admin User:**
- Email: `admin@example.com`
- Password: `password`

**Customer Demo User:**
- Email: `customer@example.com`
- Password: `password`

## Folder Structure Highlights

- `app/Http/Controllers/Admin/*` - Dedicated controllers for Admin Panel CRUD operations.
- `app/Http/Controllers/*` - Public and Customer controllers (`CartController`, `CheckoutController`, etc).
- `app/Http/Middleware/IsAdmin.php` - Custom middleware protecting admin routes based on user role.
- `app/Models/*` - Eloquent Models (`User`, `Category`, `Product`, `Order`, `OrderItem`) with defined relationships.
- `database/migrations/*` - Database schema files with proper foreign keys and indexes.
- `database/seeders/*` - Seeders generating sample categories, 20+ products, and users.
- `resources/views/layouts/public.blade.php` - Custom Bootstrap 5 layout for the public store.
- `resources/views/layouts/admin.blade.php` - Custom Bootstrap 5 layout for the admin panel.

## Architecture & Code Quality Rules Followed
- Used standard Eloquent ORM relationships (NO raw SQL).
- Used route model binding and slug-based URLs.
- Used database transactions for checkout consistency.
- Proper MVC separation with resourceful controllers.
- No TODOs left behind.

## SQL-Ready Schema
The schema is managed perfectly via Laravel Migrations. Once you run `php artisan migrate --seed`, the `ecommerce_poc` database will contain:
- `users` (with `role` enum)
- `categories` (with self-referencing `parent_id` FK and slug index)
- `products` (with FK to categories and slug index)
- `orders` (with JSON `shipping_address` and FK to users)
- `order_items` (with FKs to orders and products)

## Screenshots Mockup Suggestions
- **Home**: A large dark hero banner with "Shop Now" button, followed by 8 featured product cards with hover effects.
- **Catalogue**: Left sidebar with Search input and Category select dropdown. Right side displaying a grid of products with pagination.
- **Cart**: A clean table showing product thumbnail, name, quantity update input, and a right-aligned Order Summary box with Checkout button.
- **Admin Dashboard**: 4 top summary cards (Total Orders, Revenue, Products, Customers) and a recent orders table below it. Left vertical dark sidebar for navigation.
