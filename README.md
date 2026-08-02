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

The application integrates with an external Credit Score API.
- The logic is decoupled into a dedicated `CreditScoreController` which simulates the external provider.
- In the `LeadApiController`, when a new lead is received, the backend uses Laravel's `Http` facade to make an authenticated POST request to the `/api/credit-score` endpoint, passing the user's PAN card number.
- The API processes the request and returns a JSON response with the credit score, which is then immediately utilized by the BRE.

## Setup Instructions

### Prerequisites
- PHP 8.2 or higher
- Composer
- MySQL 8.0+

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
   Update your `.env` file with your local MySQL credentials:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=loanbridge
   DB_USERNAME=root
   DB_PASSWORD=
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

## Testing

A comprehensive Postman Collection (`LoanBridge_Postman_Collection.json`) is included in the root directory for easy API testing and validation. Additionally, a MySQL database dump (`database_dump.sql`) is provided for rapid restoration of a pre-populated state.
