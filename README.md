# MoneyBeing Loan Eligibility & Lead Management

This project is a Laravel 11 application for processing loan applications, calculating credit scores, and evaluating business rules to determine eligibility.

## Setup Instructions

### Prerequisites
- Docker & Docker Compose
- PHP 8.2+
- Composer

### Installation
1. Clone the repository or navigate to the project directory.
2. Run `composer install` to install dependencies.
3. Make sure the `.env` file is present (copied from `.env.example`).
4. Ensure the database credentials in `.env` are set for MySQL:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3307
   DB_DATABASE=moneybeing
   DB_USERNAME=laravel
   DB_PASSWORD=password
   ```
5. Start the Docker database container:
   ```bash
   docker compose up -d
   ```
   *Note: Wait a few seconds for the MySQL container to initialize.*
6. Run database migrations and seed default Business Rules:
   ```bash
   php artisan migrate --seed
   ```
7. Start the application:
   ```bash
   php artisan serve
   ```
8. The application will be accessible at `http://localhost:8000`.

### Features
- **Module 1**: Customer Loan Application Form available at `/`.
- **Module 2**: Credit Score Integration (Mocked randomly between 600-850 in `LeadApiController`).
- **Module 3**: Business Rule Engine dynamically evaluates eligibility based on DB rules.
- **Module 4 & 5 & 6**: Admin Dashboard at `/admin`, Lead Management at `/admin/leads`, and BRE Management at `/admin/rules`.
- **Module 7**: REST API at `POST /api/leads`.
- **Module 8**: Duplicate validation based on mobile numbers.

### Bonus Features Included
- **Docker Setup**: `docker-compose.yml` included for MySQL.
- **SQL Database Dump**: `database_dump.sql` provided.
- **Postman Collection**: `MoneyBeing_Postman_Collection.json` provided.

### Assessment Notes
The API endpoints use a simulated Credit Score fetch. If required, the exact credit score integration logic can easily be swapped with real HTTP calls inside `app/Http/Controllers/Api/LeadApiController.php`.
