# E-Commerce POC Project: Comprehensive Technical Report

---

## 1. Executive Summary

This document serves as the comprehensive final report for the E-Commerce Proof of Concept (POC) Application built using the Laravel 11 framework. The primary objective of this project was to transition from a raw PHP-based architecture to a modern, robust, and highly structured MVC framework environment. This POC demonstrates the implementation of a full-fledged e-commerce platform, complete with a public-facing storefront, a session-based shopping cart, a secure checkout process utilizing database transactions, and a protected administrative dashboard for managing the product catalog and processing orders.

By leveraging Laravel's extensive ecosystem, including Eloquent ORM, Blade templating, and built-in authentication via Laravel Breeze, the application achieves a high standard of code maintainability, security, and scalability. This report details the architectural decisions, module breakdowns, database schema, security implementations, and comprehensive API/route documentation.

---

## 2. GitHub Repository

**Repository Link:** [https://github.com/Achyut-Pancholi/E-Commerce-POC](https://github.com/Achyut-Pancholi/E-Commerce-POC)

*Note: The `README.md` file within the repository contains the complete environment setup instructions, including commands for `composer install`, `.env` configuration, `php artisan migrate`, `php artisan db:seed`, and `php artisan serve`.*

---

## 3. Team Contributions & Acknowledgments

This project was developed collaboratively, with clear boundaries of responsibility to ensure focused development and timely delivery.

- **Authentication and Authorization Integration:** 
  **Bherulal Meghwal** took complete ownership of the authentication layer. This involved integrating Laravel Breeze, configuring session-based authentication guards, establishing role-based access control (RBAC) to differentiate between `admin` and `customer` accounts, and securing all protected routes utilizing custom middleware.
  
- **Core Platform & Feature Development:** 
  **Achyut Pancholi** was responsible for the remainder of the application. This included designing the database architecture, building the product catalog, implementing the session-driven shopping cart, engineering the transactional checkout system, and developing the entire administrative dashboard for product and order management.

---

## 4. Architectural Overview

The application is built strictly adhering to the **Model-View-Controller (MVC)** architectural pattern provided by Laravel.

### 4.1 Models (Eloquent ORM)
All database interactions are handled via Laravel's Eloquent ORM. No raw SQL queries were used in the application. Models (`User`, `Product`, `Category`, `Order`, `OrderItem`) define the data structure and encapsulate complex relationships (e.g., One-to-Many between Categories and Products, Many-to-Many encapsulated via pivot tables or direct OrderItem relations). Eloquent's Mutators and Accessors are used to format data (like pricing) uniformly.

### 4.2 Views (Blade Templating)
The presentation layer is powered by Laravel Blade. We utilized layout inheritance to create consistent wrappers for the Public Storefront (`public.blade.php`) and the Admin Panel (`admin.blade.php`). Blade components and directives (`@auth`, `@foreach`, `@if`) were heavily used to keep the views clean and free of raw PHP logic. The UI is responsive and styled using Bootstrap 5.

### 4.3 Controllers
Controllers act as the orchestrators. We utilized **Resourceful Controllers** for admin CRUD operations (`ProductController`, `CategoryController`), ensuring standard RESTful routing. **Single Action Controllers** or focused controllers (`CartController`, `CheckoutController`) were used for specific business logic. Route Model Binding was universally applied to automatically resolve Eloquent models from URL parameters (e.g., injecting a `Product` model directly based on its slug).

---

## 5. Detailed Module Breakdown

### 5.1 Authentication & Role-Based Access Control (RBAC)
Implemented by Bherulal Meghwal, the auth system uses Laravel Breeze. Users are assigned roles upon creation. A custom middleware (`IsAdmin`) intercepts requests to the `/admin/*` namespace, checking the user's role. If a customer attempts to access the admin panel, they are redirected with an unauthorized error, ensuring strict separation of concerns.

### 5.2 Public Storefront & Product Catalog
The public catalog allows users to browse products, filter them by category, and search by keywords. Pagination is handled natively by Eloquent's `paginate()` method, automatically rendering Bootstrap-compatible pagination links in the Blade views.

### 5.3 Session-Based Shopping Cart
To allow guest users to shop, the cart relies on Laravel's Session facade. Cart items are stored as multi-dimensional arrays within the session. The `CartController` handles adding items (with quantity validation), updating quantities, and removing items. 

### 5.4 Transactional Checkout System
The checkout process is one of the most critical components. It utilizes **Database Transactions** (`DB::transaction()`). When a user submits their shipping details, the system:
1. Creates an `Order` record.
2. Iterates over session cart items, creating `OrderItem` records.
3. Deducts the purchased quantities from the `Product` inventory.
4. Clears the session cart.
If any step fails (e.g., insufficient stock), the entire transaction rolls back, preventing data corruption or overselling.

---

## 6. Screenshots & UI Previews

Below are the designated placeholders for the required UI screenshots.

### 6.1 Product Catalogue
*(Displays the grid of available products, category sidebar, and search functionality)*
**[Insert Screenshot Here: Product Catalogue]**

### 6.2 Admin Product Form
*(Displays the Create/Edit Product interface with image upload, WYSIWYG editor, and validation errors)*
**[Insert Screenshot Here: Admin Product Form]**

### 6.3 Shopping Cart
*(Displays the tabular view of cart items, quantity adjusters, and the order summary total)*
**[Insert Screenshot Here: Cart]**

### 6.4 Order Confirmation
*(Displays the success screen after checkout, outlining order ID and next steps)*
**[Insert Screenshot Here: Order Confirmation]**

### 6.5 Git PR List
*(Displays the GitHub repository Pull Requests tab, showcasing collaborative workflow)*
**[Insert Screenshot Here: Git PR List]**

---

## 7. Database Architecture & Schema

The database relies on strict foreign key constraints to maintain referential integrity. 

- **`users` Table:** Stores authentication credentials and role (`admin` or `customer`).
- **`categories` Table:** Supports hierarchical data via a self-referencing `parent_id`. Includes a unique `slug`.
- **`products` Table:** Contains product metadata, pricing, stock levels, and a `category_id` foreign key.
- **`orders` Table:** Tracks customer orders, total amounts, status (`pending`, `shipped`, `delivered`), and stores the shipping address as a JSON column for historical integrity. Linked to `user_id`.
- **`order_items` Table:** The intermediary linking `orders` and `products`, storing the snapshot price and quantity at the time of purchase.

### Database ER Diagram
*(Visual representation of the aforementioned schema exported from MySQL Workbench / dbdiagram.io)*
**[Insert Screenshot Here: Database ER Diagram]**

---

## 8. Reflection

**How did Laravel's conventions speed up your development compared to the raw PHP REST API in POC 1?**

Laravel's conventions significantly accelerated development by eliminating boilerplate code and providing robust out-of-the-box tools. Features like Eloquent ORM relationships and migrations replaced writing tedious raw SQL queries, ensuring faster and more secure database interactions. Route model binding and resourceful controllers streamlined routing and standardized CRUD operations instantly. The built-in session management made implementing a reliable cart simple, compared to manually handling session states in raw PHP. Additionally, Laravel Blade templating allowed for rapid UI scaffolding without messy PHP logic interspersed in HTML. Overall, adhering to Laravel's structured MVC architecture meant spending less time on reinventing the wheel and more time focusing on core application features like checkout flows and admin dashboards.


---

## 9. Comprehensive cURL Documentation

While this application is a session-based monolithic web application (returning HTML views rather than JSON), the underlying HTTP requests can still be mapped. Below are the equivalent cURL commands for all major routes in the system. 

*Note: For POST/PATCH/DELETE requests in Laravel, a valid CSRF token (`_token`) and session cookie (`laravel_session`) are strictly required.*

### 9.1 Public Routes

**View Home Page**
```bash
curl -X GET http://127.0.0.1:8000/ \
  -H "Accept: text/html"
```

**View Product Catalogue**
```bash
curl -X GET http://127.0.0.1:8000/products \
  -H "Accept: text/html"
```

**View Single Product Detail**
```bash
curl -X GET http://127.0.0.1:8000/products/sample-product-slug \
  -H "Accept: text/html"
```

### 9.2 Cart Management

**View Cart**
```bash
curl -X GET http://127.0.0.1:8000/cart \
  -b "laravel_session=YOUR_SESSION_ID" \
  -H "Accept: text/html"
```

**Add Item to Cart**
```bash
curl -X POST http://127.0.0.1:8000/cart/add/1 \
  -b "laravel_session=YOUR_SESSION_ID" \
  -H "Content-Type: application/x-www-form-urlencoded" \
  -d "_token=YOUR_CSRF_TOKEN" \
  -d "quantity=2"
```

**Update Cart Item Quantity**
```bash
curl -X POST http://127.0.0.1:8000/cart/update/1 \
  -b "laravel_session=YOUR_SESSION_ID" \
  -H "Content-Type: application/x-www-form-urlencoded" \
  -d "_token=YOUR_CSRF_TOKEN" \
  -d "quantity=5"
```

**Remove Item from Cart**
```bash
curl -X POST http://127.0.0.1:8000/cart/remove/1 \
  -b "laravel_session=YOUR_SESSION_ID" \
  -H "Content-Type: application/x-www-form-urlencoded" \
  -d "_token=YOUR_CSRF_TOKEN"
```

### 9.3 Checkout Process (Authenticated)

**View Checkout Page**
```bash
curl -X GET http://127.0.0.1:8000/checkout \
  -b "laravel_session=YOUR_SESSION_ID" \
  -H "Accept: text/html"
```

**Submit Checkout Order**
```bash
curl -X POST http://127.0.0.1:8000/checkout \
  -b "laravel_session=YOUR_SESSION_ID" \
  -H "Content-Type: application/x-www-form-urlencoded" \
  -d "_token=YOUR_CSRF_TOKEN" \
  -d "shipping_address[name]=John Doe" \
  -d "shipping_address[address]=123 Main St" \
  -d "shipping_address[city]=New York" \
  -d "shipping_address[state]=NY" \
  -d "shipping_address[zip]=10001" \
  -d "shipping_address[country]=USA"
```

### 9.4 Authentication Routes

**Submit Login Form**
```bash
curl -X POST http://127.0.0.1:8000/login \
  -H "Content-Type: application/x-www-form-urlencoded" \
  -d "_token=YOUR_CSRF_TOKEN" \
  -d "email=customer@example.com" \
  -d "password=password"
```

**Logout**
```bash
curl -X POST http://127.0.0.1:8000/logout \
  -b "laravel_session=YOUR_SESSION_ID" \
  -H "Content-Type: application/x-www-form-urlencoded" \
  -d "_token=YOUR_CSRF_TOKEN"
```

---

## 10. Postman Collection (Exported JSON)

To facilitate immediate testing and understanding of the routing structure, below is the raw JSON representation of a Postman Collection covering all primary routes. You can save the block below as `ECommerce_POC.postman_collection.json` and import it directly into Postman.

```json
{
  "info": {
    "_postman_id": "c8b4e7e1-8a9d-4e9b-9c2b-3a5c1d6b9f2e",
    "name": "E-Commerce POC Laravel 11",
    "description": "Complete collection of web routes for the E-Commerce Proof of Concept Application. Note: As this is a web application with session state, you must configure Postman to intercept and pass cookies (`laravel_session`, `XSRF-TOKEN`) and include a CSRF token for POST/PATCH/DELETE requests.",
    "schema": "https://schema.getpostman.com/json/collection/v2.1.0/collection.json"
  },
  "item": [
    {
      "name": "1. Public Routes",
      "item": [
        {
          "name": "View Home Page",
          "request": {
            "method": "GET",
            "header": [],
            "url": {
              "raw": "{{base_url}}/",
              "host": ["{{base_url}}"],
              "path": [""]
            }
          }
        },
        {
          "name": "View Product Catalogue",
          "request": {
            "method": "GET",
            "header": [],
            "url": {
              "raw": "{{base_url}}/products",
              "host": ["{{base_url}}"],
              "path": ["products"]
            }
          }
        },
        {
          "name": "View Single Product",
          "request": {
            "method": "GET",
            "header": [],
            "url": {
              "raw": "{{base_url}}/products/sample-product",
              "host": ["{{base_url}}"],
              "path": ["products", "sample-product"]
            }
          }
        }
      ]
    },
    {
      "name": "2. Authentication",
      "item": [
        {
          "name": "Get CSRF Cookie",
          "request": {
            "method": "GET",
            "header": [],
            "url": {
              "raw": "{{base_url}}/sanctum/csrf-cookie",
              "host": ["{{base_url}}"],
              "path": ["sanctum", "csrf-cookie"]
            }
          }
        },
        {
          "name": "Login",
          "request": {
            "method": "POST",
            "header": [
              { "key": "Content-Type", "value": "application/x-www-form-urlencoded" }
            ],
            "body": {
              "mode": "urlencoded",
              "urlencoded": [
                { "key": "email", "value": "customer@example.com", "type": "text" },
                { "key": "password", "value": "password", "type": "text" },
                { "key": "_token", "value": "{{csrf_token}}", "type": "text" }
              ]
            },
            "url": {
              "raw": "{{base_url}}/login",
              "host": ["{{base_url}}"],
              "path": ["login"]
            }
          }
        }
      ]
    },
    {
      "name": "3. Cart Management",
      "item": [
        {
          "name": "View Cart",
          "request": {
            "method": "GET",
            "header": [],
            "url": {
              "raw": "{{base_url}}/cart",
              "host": ["{{base_url}}"],
              "path": ["cart"]
            }
          }
        },
        {
          "name": "Add Item to Cart",
          "request": {
            "method": "POST",
            "header": [
              { "key": "Content-Type", "value": "application/x-www-form-urlencoded" }
            ],
            "body": {
              "mode": "urlencoded",
              "urlencoded": [
                { "key": "quantity", "value": "1", "type": "text" },
                { "key": "_token", "value": "{{csrf_token}}", "type": "text" }
              ]
            },
            "url": {
              "raw": "{{base_url}}/cart/add/1",
              "host": ["{{base_url}}"],
              "path": ["cart", "add", "1"]
            }
          }
        },
        {
          "name": "Update Cart Item",
          "request": {
            "method": "POST",
            "header": [
              { "key": "Content-Type", "value": "application/x-www-form-urlencoded" }
            ],
            "body": {
              "mode": "urlencoded",
              "urlencoded": [
                { "key": "quantity", "value": "3", "type": "text" },
                { "key": "_token", "value": "{{csrf_token}}", "type": "text" }
              ]
            },
            "url": {
              "raw": "{{base_url}}/cart/update/1",
              "host": ["{{base_url}}"],
              "path": ["cart", "update", "1"]
            }
          }
        },
        {
          "name": "Remove Cart Item",
          "request": {
            "method": "POST",
            "header": [
              { "key": "Content-Type", "value": "application/x-www-form-urlencoded" }
            ],
            "body": {
              "mode": "urlencoded",
              "urlencoded": [
                { "key": "_token", "value": "{{csrf_token}}", "type": "text" }
              ]
            },
            "url": {
              "raw": "{{base_url}}/cart/remove/1",
              "host": ["{{base_url}}"],
              "path": ["cart", "remove", "1"]
            }
          }
        }
      ]
    },
    {
      "name": "4. Checkout",
      "item": [
        {
          "name": "Submit Checkout",
          "request": {
            "method": "POST",
            "header": [
              { "key": "Content-Type", "value": "application/x-www-form-urlencoded" }
            ],
            "body": {
              "mode": "urlencoded",
              "urlencoded": [
                { "key": "shipping_address[name]", "value": "John Doe", "type": "text" },
                { "key": "shipping_address[address]", "value": "123 Main St", "type": "text" },
                { "key": "shipping_address[city]", "value": "New York", "type": "text" },
                { "key": "shipping_address[state]", "value": "NY", "type": "text" },
                { "key": "shipping_address[zip]", "value": "10001", "type": "text" },
                { "key": "shipping_address[country]", "value": "USA", "type": "text" },
                { "key": "_token", "value": "{{csrf_token}}", "type": "text" }
              ]
            },
            "url": {
              "raw": "{{base_url}}/checkout",
              "host": ["{{base_url}}"],
              "path": ["checkout"]
            }
          }
        }
      ]
    },
    {
      "name": "5. Admin Panel",
      "item": [
        {
          "name": "Admin Dashboard",
          "request": {
            "method": "GET",
            "header": [],
            "url": {
              "raw": "{{base_url}}/admin",
              "host": ["{{base_url}}"],
              "path": ["admin"]
            }
          }
        },
        {
          "name": "Admin Orders List",
          "request": {
            "method": "GET",
            "header": [],
            "url": {
              "raw": "{{base_url}}/admin/orders",
              "host": ["{{base_url}}"],
              "path": ["admin", "orders"]
            }
          }
        },
        {
          "name": "Admin Update Order Status",
          "request": {
            "method": "PATCH",
            "header": [
              { "key": "Content-Type", "value": "application/x-www-form-urlencoded" }
            ],
            "body": {
              "mode": "urlencoded",
              "urlencoded": [
                { "key": "status", "value": "shipped", "type": "text" },
                { "key": "_token", "value": "{{csrf_token}}", "type": "text" }
              ]
            },
            "url": {
              "raw": "{{base_url}}/admin/orders/1/status",
              "host": ["{{base_url}}"],
              "path": ["admin", "orders", "1", "status"]
            }
          }
        }
      ]
    }
  ],
  "event": [
    {
      "listen": "prerequest",
      "script": {
        "type": "text/javascript",
        "exec": [
          "// Ensure CSRF tokens are handled in Postman environment variables if needed"
        ]
      }
    }
  ],
  "variable": [
    {
      "key": "base_url",
      "value": "http://127.0.0.1:8000",
      "type": "string"
    },
    {
      "key": "csrf_token",
      "value": "YOUR_CSRF_TOKEN_HERE",
      "type": "string"
    }
  ]
}
```
