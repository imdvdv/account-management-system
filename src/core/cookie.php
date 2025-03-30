<?php

namespace core\cookie;

function set(string $key, string $value, $expiration_date, string $path = COOKIE_SETTINGS['path'], string $domain = COOKIE_SETTINGS['domain'], bool $secure = COOKIE_SETTINGS['secure'], bool $httponly = COOKIE_SETTINGS['httponly']): void
{   
    setcookie($key, $value, $expiration_date, $path, $domain, $secure, $httponly);
}

function has(string $key): bool
{
    return isset($_COOKIE[$key]);
}

function get(?string $key = null, string $default = null): mixed
{
    return is_string($key) ? $_COOKIE[$key] ?? $default : $_COOKIE;
}

function remove(string $key, $path = COOKIE_SETTINGS['path']): void
{
    setcookie($key, '', time() - ONE_WEEK, $path);
}