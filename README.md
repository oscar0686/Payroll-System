# Payroll Management System

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About This Project

This is a comprehensive **Payroll Management System** built with Laravel that automates employee payroll calculations with statutory deductions for Kenyan tax requirements. The system provides a complete solution for managing employee records and generating accurate payroll with automatic tax calculations.

## Key Features

### Employee Management
- **Add Employees**: Create new employee records with personal and employment details
- **Edit Employees**: Update existing employee information
- **Delete Employees**: Remove employee records from the system
- **View Employees**: Display comprehensive employee listings and individual profiles
- **Salary Assignment**: Assign and modify employee salary structures

### Payroll Management
- **Automated Payroll Generation**: Generate payroll for individual employees or bulk processing
- **Statutory Deductions**: Automatic calculation of Kenyan statutory deductions including:
  - **SHIF (Social Health Insurance Fund)**: KES 500 flat rate
  - **Housing Levy**: 1.5% of gross salary
  - **PAYE (Pay As You Earn)**: 30% income tax on taxable income
- **Net Salary Calculation**: Automatic computation of net pay after all deductions
- **Payroll Reports**: Generate detailed payroll reports with breakdowns

### Technical Features
- **Responsive Design**: Mobile-friendly interface using Bootstrap
- **Data Validation**: Comprehensive form validation for data integrity
- **Database Relationships**: Proper relational database structure
- **Error Handling**: Robust error handling and user feedback
- **Clean Architecture**: Following Laravel best practices and MVC pattern

## Technology Stack

- **Framework**: Laravel 10.x
- **Database**: MySQL
- **Frontend**: Blade Templates with Bootstrap 5
- **Authentication**: Laravel's built-in authentication
- **Styling**: Bootstrap CSS Framework
- **Icons**: Font Awesome
- **Server Requirements**: PHP 8.1+

## Installation & Setup

### Prerequisites
- PHP >= 8.1
- Composer
- MySQL/MariaDB
- Node.js & NPM (for asset compilation)

### Installation Steps

1. **Clone the repository**
   ```bash
   git clone https://github.com/oscar0686/Payroll-System.git
   cd Payroll-System
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install JavaScript dependencies**
   ```bash
   npm install
   ```

4. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configure database**
   Edit `.env` file with your database credentials:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=payroll_system
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

6. **Run database migrations**
   ```bash
   php artisan migrate
   ```

7. **Seed database (optional)**
   ```bash
   php artisan db:seed
   ```

8. **Compile assets**
   ```bash
   npm run dev
   ```

9. **Start the development server**
   ```bash
   php artisan serve
   ```

10. **Access the application**
    Open your browser and navigate to `http://localhost:8000`

## Usage Examples

### Adding an Employee
1. Navigate to "Employees" section
2. Click "Add New Employee"
3. Fill in employee details including salary
4. Save the employee record

### Generating Payroll
1. Go to "Payroll" section
2. Select employee or generate for all employees
3. System automatically calculates:
   - Gross Salary: KES 10,000
   - SHIF Deduction: KES 500
   - Housing Levy (1.5%): KES 150
   - PAYE (30%): KES 2,805 (on taxable income)
   - **Net Salary: KES 6,545**

## Database Structure

### Employees Table
- Personal information (name, email, phone, etc.)
- Employment details (position, department, hire date)
- Salary information (basic salary, allowances)

### Payroll Table
- Employee reference
- Salary breakdown
- Deduction calculations
- Net pay computation
- Pay period information

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request. For major changes, please open an issue first to discuss what you would like to change.

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Support

If you encounter any issues or have questions, please create an issue in the GitHub repository.

---

**Developed by Oscar Okumu** - Software Developer  
**Contact**: [Your Email] | **GitHub**: [@oscar0686](https://github.com/oscar0686)
