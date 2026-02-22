# VIP Driving School Hobart - Booking System

This is a comprehensive booking and management system for VIP Driving School Hobart, built with Laravel. It features instructor management, availability slot management, automated booking flows with Stripe payment integration, and a dedicated admin dashboard.

## 🚀 Local Development Setup

Follow these steps to get the project running on your local machine.

### Prerequisites

Ensure you have the following installed:
- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL/MariaDB (Or WAMP/XAMPP for Windows)

### 1. Installation

Clone the repository and navigate to the backend directory:
```bash
cd vipdrivingschoolhobart/backend
```

Install PHP dependencies:
```bash
composer install
```

Install Javascript dependencies:
```bash
npm install
```

### 2. Configuration

Create your environment file:
```bash
cp .env.example .env
```

Generate the application key:
```bash
php artisan key:generate
```

### 3. Database Setup

1. Create a database in MySQL (e.g., `vip_driving_school`).
2. Update your `.env` file with the database credentials:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=vip_driving_school
DB_USERNAME=root
DB_PASSWORD=
```

Run migrations and seed the database:
```bash
php artisan migrate --seed
```

### 4. Storage & Assets

Link the storage directory to the public folder:
```bash
php artisan storage:link
```

Build the assets:
```bash
npm run dev
# OR for production
npm run build
```

### 5. Running the Application

Start the local development server:
```bash
php artisan serve
```
*Note: If you need to run it on a specific IP for testing on other devices (e.g., mobile), use:*
```bash
php artisan serve --host=192.168.10.234 --port=8000
```

The application will be accessible at `http://localhost:8000` (or your specified IP).

---

## 🛠️ Key Features

- **Dynamic Booking Form**: Multi-step booking process with service, location, and instructor selection.
- **Instructor Management**: Manage profiles, photos, and specific availability.
- **Availability Groups**: Synchronized slot management for multiple instructors.
- **Stripe Integration**: Secure payment processing for bookings.
- **Admin Dashboard**: AdminLTE based dashboard for managing all school operations.

## 🔑 Admin Access

Default admin credentials (if seeded):
- **URL**: `http://localhost:8000/admin`
- **Email**: `admin@vipdrivingschool.com.au`
- **Password**: `password123` (check `UserSeeder.php` for details)

## 📦 Commands Reference

| Command | Description |
|---------|-------------|
| `php artisan serve` | Starts the dev server |
| `npm run dev` | Starts Vite for asset hot-reloading |
| `php artisan migrate` | Runs pending migrations |
| `php artisan db:seed` | Fills database with initial data |
| `php artisan route:list` | View all registered routes |

---
© 2026 VIP Driving School Hobart. All rights reserved.
