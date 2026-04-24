# 📦 Inventory Service API

A production-ready Inventory Management API built with Laravel, Docker, PostgreSQL, and Redis.

---

## 🚀 Features

* Product CRUD (Create, Read, Update, Delete)
* Stock Management (Increment / Decrement)
* Low Stock Detection using Events & Listeners
* Redis Caching for performance optimization
* Rate Limiting for API protection
* Clean Architecture (Repository Pattern + API Resources)
* Feature Tests (API Testing)
* Dockerized environment (easy setup)

---

## 🛠️ Tech Stack

* PHP 8.3
* Laravel 11
* PostgreSQL
* Redis
* Docker & Docker Compose

---

## ⚙️ Setup Instructions

### 1. Clone the repository

```bash
git clone <your-repo-url>
cd inventory-service
```

---

### 2. Start Docker containers

```bash
docker compose up -d --build
```

---

### 3. Enter the application container

```bash
docker exec -it inventory_app bash
```

---

### 4. Install dependencies

```bash
composer install
```

---

### 5. Setup environment

```bash
cp .env.example .env
php artisan key:generate
```

---

### 6. Run migrations

```bash
php artisan migrate
```

---

### 7. (Optional) Create testing database

```bash
docker exec -it inventory-db psql -U postgres -c "CREATE DATABASE inventory_test;"
```

---

### 8. Run tests

```bash
php artisan test
```

---

## 📡 API Endpoints

### 🔹 Products

| Method | Endpoint           | Description        |
| ------ | ------------------ | ------------------ |
| GET    | /api/products      | Get all products   |
| GET    | /api/products/{id} | Get single product |
| POST   | /api/products      | Create product     |
| PUT    | /api/products/{id} | Update product     |
| DELETE | /api/products/{id} | Delete product     |

---

### 🔹 Stock Management

| Method | Endpoint                 | Description                          |
| ------ | ------------------------ | ------------------------------------ |
| POST   | /api/products/{id}/stock | Adjust stock (increment / decrement) |

#### Example Request:

```json
{
  "type": "increment",
  "quantity": 10
}
```

---

### 🔹 Low Stock

| Method | Endpoint                | Description            |
| ------ | ----------------------- | ---------------------- |
| GET    | /api/products/low-stock | Get low stock products |

---

## 🧠 Architecture Overview

This project follows a clean and scalable architecture:

* **Controllers** → Handle HTTP requests
* **Requests** → Validation layer
* **Repositories** → Business logic & data access
* **Resources** → API response formatting
* **Events & Listeners** → Handle low stock alerts

---

## ⚡ Caching Strategy

* Product listing is cached using Redis
* Cache is cleared on:

  * Create product
  * Update product
  * Delete product
  * Adjust stock

---

## 🔐 Rate Limiting

API is protected using Laravel rate limiting:

* Default: 60 requests per minute per IP

---

## 🔔 Events System

Low stock is handled using:

* Event: `LowStockDetected`
* Listener: `SendLowStockAlert`

Triggered when:

```
stock_quantity < low_stock_threshold
```

---

## 🧪 Testing

Feature tests cover:

* Product creation
* Product listing
* Product retrieval
* Product update
* Stock adjustment

Run tests:

```bash
php artisan test
```

---

## 📌 Notes

* Uses UUID for product IDs
* Docker ensures consistent environment
* PostgreSQL used as primary database
* Redis used for caching

---

## 👨‍💻 Author

Ahmed Khaled
# Inventory-system-task
# Inventory-system-task
