# ERP System

A comprehensive Enterprise Resource Planning (ERP) system built with Laravel framework.

## Features

- **User Management**: Admin, HR Manager, and Employee roles
- **Employee Management**: Complete employee information and status tracking
- **Task Management**: Assign and track tasks across the organization
- **Password Management**: Secure password storage and management
- **Role-based Access Control**: Different access levels for different user types

## Quick Start

### Prerequisites

- PHP 8.2 or higher
- MySQL 5.7 or higher
- Composer
- Node.js and NPM

### Installation

1. Clone the repository
2. Install PHP dependencies: `composer install`
3. Install Node.js dependencies: `npm install`
4. Copy `.env.example` to `.env` and configure your database settings
5. Generate application key: `php artisan key:generate`
6. Run migrations: `php artisan migrate`
7. Seed the database: `php artisan db:seed --class=AdminUserSeeder`
8. Start the development server: `php artisan serve`

## Login Credentials

### Admin Access
- **Email**: `admin@erp.com`
- **Password**: `password123`
- **Role**: System Administrator
- **Access**: Full system access

### HR Manager Access
- **Email**: `hr@erp.com`
- **Password**: `password123`
- **Role**: HR Manager
- **Access**: HR management, employee management, task assignment

### Employee Access
- **Email**: `employee@erp.com`
- **Password**: `employee123`
- **Role**: Regular Employee
- **Access**: View assigned tasks, update task status

## Database Setup

The system uses MySQL database. Make sure to:

1. Create a database named `erp` (or update the database name in `.env`)
2. Configure your database credentials in the `.env` file
3. Run migrations to create all necessary tables
4. Run the seeder to create default users

## About Laravel

This ERP system is built on Laravel, a web application framework with expressive, elegant syntax. Laravel provides:

- [Simple, fast routing engine](https://laravel.com/docs/routing)
- [Powerful dependency injection container](https://laravel.com/docs/container)
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent)
- Database agnostic [schema migrations](https://laravel.com/docs/migrations)
- [Robust background job processing](https://laravel.com/docs/queues)
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting)

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
