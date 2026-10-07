# Budget Tracker

A web application for tracking personal spending. Users can set monthly limits for spending categories, record expenses and transactions, and view reports.

Built as a team project using Agile (Scrum) methods.

## Features

- User registration, login and profile management
- Expense and transaction tracking (add, edit, delete, CSV export)
- Category management with monthly spending limits
- Spending reports and a dashboard
- Admin dashboard for managing users

## My contribution

I built the **category management** feature:

- Add, edit and delete categories, each with a monthly limit
- Soft delete (`is_deleted` flag), so old expenses keep a valid category
- Total monthly budget shown across all categories
- Input validation (`category_validation.php`) for empty names and invalid limits
- PHPUnit tests that call the validation function with normal and edge-case inputs

## Tech stack

- PHP (PDO with prepared statements)
- MySQL
- HTML / CSS
- PHPUnit (via Composer)
- Git, Agile/Scrum

## How to run locally

1. Install [XAMPP](https://www.apachefriends.org/) and start **Apache** and **MySQL**.
2. Copy this project into the `htdocs` folder.
3. In phpMyAdmin, create a database named `budget_tracker` and import `database/budget_tracker.sql`.
4. Check the database settings in `config.php` (default: user `root`, empty password).
5. Open `http://localhost/<project-folder>/login/login.php` in your browser.

## Run the tests

```
composer install
vendor/bin/phpunit tests/CategoryValidationTest.php
```

## Possible improvements

- Use a POST request with a CSRF token for deleting categories instead of a GET link
- Move more logic into functions so it can be unit tested
- Add automated tests for the other modules

## Author

Samragyi, BSc (Hons) Computer Science, Niels Brock Copenhagen Business College
