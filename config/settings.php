<?php

define('ROOT', dirname(__DIR__));
const CONFIG = ROOT . '/config';
const ROUTES = CONFIG . '/routes.php';
const APP = ROOT . '/src/app';
const MODELS = APP . '/models';
const VIEWS = APP . '/views';
const CONTROLLERS = APP . '/controllers';
const CORE = ROOT . '/src/core';
const MIDDLEWARE = CORE . '/middleware';
const HELPERS = CORE . '/helpers';
const PUBLIC_DIR = ROOT . '/public';
const UPLOADS_DIR = PUBLIC_DIR . '/uploads';
const LOGS_DIR = ROOT . '/src/logs';
const BASE_URL = 'YOUR_BASE_URL'; // http://localhost (for example)
const APP_TITLE = 'AMS';

const TIMEZONE = 'UTC';
const ONE_HOUR = 3600,
    ONE_WEEK = 604800,
    ONE_MONTH = ONE_WEEK * 4;

const SESSION_SETTINGS = [
    'strict_mode' => 1,
    'only_cookies' => 1,
    'path' => '/',
    'domain' => '',
    'secure' => false,
    'httponly' => true
];

const COOKIE_SETTINGS = [
    'path' => '/',
    'domain' => '',
    'secure' => false,
    'httponly' => true,
];

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

const DROPDOWN_SETTINGS = [
    'template' => 'partials/dropdown',
];

const POPUP_SETTINGS = [
    'template' => 'partials/popup/template',
];

const ALLOWED_REFERERS = [
    'popup/upload-avatar' => ['/', '/profile'],
    'popup/reset-sessions' => ['/', '/profile'],
    'popup/delete-profile' => ['/', '/profile'],
];

const DEFAULT_USER_AVATAR = '/assets/img/avatars/default-user-avatar.png';



