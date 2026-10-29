# COVID-19 Information Website — STQA Mini Project

A responsive educational COVID-19 information website built with HTML, CSS, JavaScript, PHP and MySQL. This Software Testing and Quality Assurance mini-project includes regular-expression test cases for form validation.

## Features
- COVID-19 awareness homepage with links to trusted health sources
- User registration, login and logout
- User comments stored in MySQL
- Regex test page for name, email, mobile number, password and comment validation
- Responsive layout
- Prepared database statements with PDO, password hashing, CSRF tokens, session hardening and output escaping

## Requirements
- XAMPP with Apache, PHP and MySQL/MariaDB
- Modern web browser

## Run locally with XAMPP
1. Download or clone this repository into `C:\xampp\htdocs\COVID19-STQA-Mini-Project`.
2. Start **Apache** and **MySQL** in the XAMPP Control Panel.
3. Open phpMyAdmin at `http://localhost/phpmyadmin`.
4. Import `database.sql`.
5. Review `config.php`. The default local settings use database `covid_website`, host `127.0.0.1`, username `root`, and a blank password. Set a password if your local MySQL account uses one.
6. Visit `http://localhost/COVID19-STQA-Mini-Project/`.
7. Open `tests.php` for the regular-expression validation examples.

## Project files
- `index.php` — home page and information
- `register.php`, `login.php`, `logout.php` — authentication
- `comments.php` — signed-in user comments
- `tests.php` — regular-expression validation examples
- `database.sql` — database and tables
- `config.php` — PDO connection and shared security helpers
- `style.css`, `script.js` — styling and client-side interactions

## Security notes
This project is intended for local learning and STQA demonstration. Use HTTPS, a dedicated least-privilege database account, secure server configuration and further security review before exposing it to the public internet. Never commit production credentials.

## Health information disclaimer
This is an educational demo, not a medical service. For current guidance, visit the [World Health Organization](https://www.who.int/health-topics/coronavirus) and the [U.S. Centers for Disease Control and Prevention](https://www.cdc.gov/covid/).

## Testing note
The included regex examples document expected pass/fail outcomes. Run the application in your local XAMPP environment to perform end-to-end tests against PHP and MySQL.
