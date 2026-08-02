# LoanBridge - Full Stack Loan Assessment Application

LoanBridge is a complete, production-ready Laravel application designed to process customer loan applications, evaluate eligibility using a dynamic Business Rule Engine (BRE), and provide a comprehensive Admin Dashboard for lead and rule management.

## Project Architecture & Overall Workflow

The application follows a standard MVC architecture within the Laravel framework:
- **Frontend**: Blade templates with Bootstrap, providing responsive forms and a clean admin interface. AJAX is used on the application form for smooth, real-time submission.
- **Backend**: Laravel handles routing, validation, and core business logic via dedicated Controllers (e.g., `LeadController`, `AdminController`).
- **Database**: MySQL is used to persist leads, administrators, and dynamic business rules.
- **Workflow**:
  1. A customer submits a loan application via the frontend form.
  2. The data is sent to the backend API (`POST /api/leads`).
  3. The system checks for duplicates based on the mobile number to prevent spam.
  4. The system automatically fetches a live credit score from an external API (`POST /api/credit-score`).
  5. The application data and credit score are fed into the Business Rule Engine (BRE).
  6. The BRE dynamically queries the database for all active rules and evaluates the lead to determine the final status (`Approved`, `Rejected`, or `Pending`).
  7. The lead is saved to the database.
  8. Administrators log into a secure dashboard to view all leads, filter them, and manage the underlying business rules dynamically.

## Business Rule Engine (BRE) Implementation

The BRE is designed to be highly flexible and completely database-driven. 
- Rules are stored in the `business_rules` table (e.g., "age > 21", "credit_score >= 650").
- Instead of hardcoding logic, the `evaluateBRE` function dynamically fetches all rules from the database.
- Each rule consists of a `field`, `operator`, and `value`. The engine iterates through the active rules and dynamically compares the lead's data against them using a match statement.
- If a lead fails any rule, they are marked as **Rejected**. If they pass all rules, they are **Approved**.
- Administrators can Add, Edit, or Delete these rules from the Admin panel without altering any code.

## Credit Score API Integration

The application integrates with a Credit Score API to enrich lead data before BRE evaluation.
- **Why a Mock API?** There are no publicly available free or token-limited CIBIL/Experian credit score checker APIs. To demonstrate the integration architecture without incurring costs, a mock Credit Bureau API was built internally using a deterministic `crc32` hashing technique on the mobile number, ensuring the same mobile always returns the same consistent credit score (range: 300–900).
- The logic is decoupled into a dedicated `CreditScoreController` (`app/Http/Controllers/Api/CreditScoreController.php`) which simulates the external provider.
- In the `LeadApiController`, when a new lead is received, the backend uses Laravel's `Http` facade to make an HTTP POST request to the `/api/credit-score/check` endpoint, passing the user's mobile number.
- The API processes the request and returns a JSON response with the credit score, which is then immediately utilized by the BRE.
- In production, this mock endpoint can be seamlessly swapped with a real third-party API without any changes to the core application logic.

## Docker Setup

The MySQL database is containerized using Docker Compose for a clean, isolated development environment. The Laravel application itself runs natively via `php artisan serve` rather than inside a container—this is intentional, as containerizing the entire app would require rebuilding the Docker image on every code change, slowing down the development workflow significantly.

To start the database container:
```bash
docker-compose up -d
```

## Setup Instructions

### Prerequisites
- PHP 8.2 or higher
- Composer
- Docker Desktop (for MySQL container) OR MySQL 8.0+ installed locally

### Installation & Local Setup

1. **Clone the repository:**
   ```bash
   git clone https://github.com/Suryachamp/LoanBridge.git
   cd LoanBridge
   ```

2. **Install dependencies:**
   ```bash
   composer install
   ```

3. **Environment Configuration:**
   Copy the example environment file and generate an application key:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database Configuration:**
   Start the Docker MySQL container or configure your own MySQL instance. Update your `.env` file accordingly:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3307
   DB_DATABASE=loanbridge
   DB_USERNAME=laravel
   DB_PASSWORD=password
   ```

5. **Run Migrations & Seeders:**
   Create the necessary tables, default admin account, and default business rules:
   ```bash
   php artisan migrate --seed
   ```
   *Default Admin Credentials:* `admin@loanbridge.com` / `password`

6. **Start the local server:**
   ```bash
   php artisan serve
   ```
   The application will be accessible at `http://localhost:8000`.

## Bonus Features & Deliverables

- **Postman Collection**: A comprehensive Postman Collection (`LoanBridge_Postman_Collection.json`) is included in the root directory for easy API testing and validation.
- **Database Dump**: A MySQL database dump (`database_dump.sql`) is provided for rapid restoration of a pre-populated database state.
- **Docker Compose**: The database is containerized via `docker-compose.yml` for one-command database provisioning.
- **Database-Driven Seeder**: Default business rules and admin credentials are auto-provisioned via `database/seeders/DatabaseSeeder.php`.
- **Duplicate Lead Prevention**: The API automatically rejects duplicate applications based on mobile number.
