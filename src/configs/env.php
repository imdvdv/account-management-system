<?php

// SESSION params
ini_set("session.use_strict_mode", 1);
ini_set("session.use_only_cookies", 1);
session_set_cookie_params([
    //"domain" => "localhost",
    "path" => "/",
    "httponly" => true,
    "secure" => true,
    "samesite" => "lax"
]);

// Database params
const DB_HOST = "your DB Host", // "localhost" for local server
    DB_NAME = "your DB Name",
    DB_USERNAME = "your DB UserName", // "root" or without password for phpMyAdmin
    DB_PASSWORD = "your DB Password", // "password" or "" for phpMyAdmin
    DB_PORT = "your DB Port"; // usually 3306

// PHPMailer params
const MAIL_HOST = "your SMTP host",
    MAIL_USERNAME = "your SMTP username", // your email address
    MAIL_PASSWORD = "your SMTP password",
    MAIL_PORT = "your SMTP port",
    MAIL_CHARSET = "UTF-8",
    MAIL_DEBUG = 0; // more details in the documentation for PHPMailer

// Timestamps
const ONE_HOUR = 3600,
    ONE_WEEK = 604800;

const VALIDATION_PARAMS = [
    // Parameters for input fields
    "fields" => [
        "name" => [
            "pattern" => "/^([A-Za-z\s]{2,30}|[А-ЯЁа-яё\s]{2,30})$/",
            "error" => "name must be at least 2 characters and contain only letters",
        ],
        "email" => [
            "pattern" => "/^[^ ]+@[^ ]+\.[a-z]{2,3}$/",
            "error" => "enter a valid email address",
        ],
        "password" => [
            "pattern" => "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{6,}$/",
            "error" => "password must be at least 6 character with number, small and capital letter",
        ],
    ],
    // Parameters only for login form
    "login_fields" => [
        "email" => [
            "pattern" => "/^[^ ]+@[^ ]+\.[a-z]{2,3}$/",
            "error" => "enter a valid email address",
        ],
        "password" => [
            "pattern" => "/^.{6,}$/",
            "error" => "password must contain at least 6 characters",
        ],
    ],
    // Parameters for attached files
    "files" => [
        "avatar" => [
            "requirements" => [
                "types" => ["image/jpeg", "image/jpg", "image/png", "image/gif"],
                "size" => 3 // MB
            ],
            "errors" => [
                "types" => "invalid file type",
                "size" => "the file should not exceed 3 MB",
            ],
        ],
    ],
    // Parameters for generated random code using for reset code or auth token checking
    "code" => [
        "pattern" => "/^(?=.*[a-z])(?=.*\d).{32}$/",
        "error" => "code is invalid"
    ]
];