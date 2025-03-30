# PHP Login System

### Project Overview

The project includes all the basic operations with a personal account such as registration, login, logout, editing user data, password recovery and deletion. Implemented on the MVC architecture using a functional approach. The main goal of the project is to learn how to implement such functionality and understand how it works without using frameworks and third-party libraries.

### Features

* __Friendly URLs:__ .htaccess file provides simple and short URLs, sparing the project from file names in the address bar.
* __Routing:__ Implemented simple routing that checks routes, HTTP methods, and also calls the action of the specified controller and middleware.
* __Sessions:__ Using built-in PHP cookie and session, a system is implemented that remembers the user by a unique token key.
* __CRUD:__ The project implements operations with database for adding, editing, deleting and reading data.
* __Templating:__ Templating on PHP allowing to render pages and parts of content.
* __Popup:__ Popup window for displaying messages or forms, implemented in the built-in templating.
* __Dropdown:__ A function implemented on the built-in templating that renders a drop-down list with the specified parameters.
* __Validation:__ Input validation system. In case of errors, error messages are displayed each under its own field.
* __Logging:__ Error logging system where log files are automatically entered by creation date into the log folder.
* __Autoload:__ Autoloading files with composer allows you to take full advantage of namespaces.
* __Sending emails:__ The system of sending messages to restore access to the account is carried out using PHPMailer.

### Components

__Languages__
* PHP-8.2.4
* MariaDB-10.4.28
* HTML5
* CSS3

__External Resources/Plugins__
* PHPMailer-6.9.1
* Font awesome-6.4.0
* Google Fonts

### Getting Started 

To use this project, follow these steps:
1. Clone the repository to your local machine.
2. Set the base URL of your project in the `config/settings.php`.
```php
const BASE_URL = 'YOUR_BASE_URL'; // http://localhost (for example)
```
3. Configure Database. 

   3.1 Create a new database with name `ams` and import the prepared dump file `config/ams.sql`.
   
   3.2 Edit the database connection details in the `config/settings.php` file.
   ```php
    const DB_SETTINGS = [
        'driver' => 'mysql',
        'host' => 'your_host',
        'db_name' => 'your_db_name', // ams
        'username' => 'your_username',
        'password' => 'your_password',
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'port' => 'your_port', // 3306
        'prefix' => '',
        'options' => [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ],
    ];
   ```
4. Configure email sending using [PHPMailer](https://github.com/PHPMailer/PHPMailer). Edit the mail settings in the `config/settings.php` file.
```php
  const MAIL_SETTINGS = [
    'host' => 'your_host', // smtp.gmail.com (for example)
    'auth' => true,
    'username' => 'your_username', // email address
    'password' => 'your_password',
    'secure' => null, // tls or ssl
    'port' => 465,
    'from_email' => 'your_email_address', // email
    'from_name' => APP_TITLE ?? 'App',
    'is_html' => true,
    'charset' => 'UTF-8',
    'debug' => 0, // 0 - 4
];
```
5. Install [Composer](https://getcomposer.org/) if you haven't already and run the following command in the project root using terminal.
```powershell
composer dump-autoload
```
6. Run the project on a server.

### Images
![signup page](https://github.com/imdvdv/account-management-system/blob/master/assets/img/preview/signup-page.png)
![signup page with errors](https://github.com/imdvdv/account-management-system/blob/master/assets/img/preview/signup-page-errors.png)
![login page](https://github.com/imdvdv/account-management-system/blob/master/assets/img/preview/login-page.png)
![forgot page](https://github.com/imdvdv/account-management-system/blob/master/assets/img/preview/access-recovery-page.png)
![change password page](https://github.com/imdvdv/account-management-system/blob/master/assets/img/preview/change-password-page.png)
![profile page](https://github.com/imdvdv/account-management-system/blob/master/assets/img/preview/profile-page.png)
![profile avatar1](https://github.com/imdvdv/account-management-system/blob/master/assets/img/preview/profile-avatar1.png)
![profile avatar2](https://github.com/imdvdv/account-management-system/blob/master/assets/img/preview/profile-avatar2.png)
![profile avatar3](https://github.com/imdvdv/account-management-system/blob/master/assets/img/preview/profile-avatar3.png)
![reset sessions popup](https://github.com/imdvdv/account-management-system/blob/master/assets/img/preview/reset-sessions-popup.png)
![delete profile popup](https://github.com/imdvdv/account-management-system/blob/master/assets/img/preview/delete-profile-popup.png)



