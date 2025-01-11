<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About the Project

This is a **restaurant management application** tailored for a VIP restaurant with **12 exclusive seats**. The project is built using **Laravel 10**, **Vue 3**, and **Bootstrap**, along with **Inertia.js** and other JavaScript helpers. It provides robust tools for managing reservations, dates, and customer interactions.

### Key Features

- **Reservation System**:
  - Fully-featured calendar for managing reservations.
  - Limited seating with dynamic availability updates.

- **Dashboards**:
  - **Admin Dashboard**: Manage reservations, view analytics, and configure settings.
  - **User Dashboard**: Allow customers to view and manage their bookings.

- **Queue Management**:
  - Background job processing with Laravel queues for sending notifications and managing asynchronous tasks.

- **Interactive Calendar**:
  - Integrated calendar for selecting dates and managing bookings in real-time.

- **Frontend Design**:
  - Responsive interface built with **Bootstrap** for a clean and professional look.

- **Other Features**:
  - Notifications for booking confirmations and reminders.
  - Custom middleware for secure route protection.
  - Intuitive and seamless user experience with **Inertia.js**.

## Installation

### Prerequisites

Ensure you have the following installed on your system:
- PHP >= 8.1
- Composer
- Node.js & npm
- MySQL or any supported database

### Steps

1. Clone the repository:
   ```bash
   git clone https://github.com/your-repository/restaurant-management.git
   cd restaurant-management
   ```

2. Install PHP dependencies:
   ```bash
   composer install
   ```

3. Install JavaScript dependencies:
   ```bash
   npm install
   ```

4. Create a `.env` file and configure your environment variables. Use `.env.example` as a template.

5. Run migrations and seeders:
   ```bash
   php artisan migrate --seed
   ```

6. Build the frontend assets:
   ```bash
   npm run dev
   ```

7. Start the local development server:
   ```bash
   php artisan serve
   ```

## Usage

### Admin Dashboard
- Manage reservations and monitor seating availability.
- Analyze customer data and trends.

### Reservation System
- Customers can book available seats directly from the calendar.
- Admin can manually add, modify, or cancel bookings.

### Notifications
- Automatically send email confirmations and reminders for reservations.

### Queue Management
- Efficient handling of background tasks, such as sending notifications and updates.

## Security

This application implements the following security features:
- Middleware for role-based route protection.
- CSRF protection for all forms and requests.
- Secure handling of sensitive data via `.env` variables.

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

---

<p align="center">Made with ❤️ using Laravel, Vue, Bootstrap, and Inertia.js.</p>
