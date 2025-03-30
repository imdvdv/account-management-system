<?php

namespace core\response;

use core\session;

function set_body(?string $status = null, ?string $message = null, ?array $values = null, ?array $errors = null, ?array $data = null): void
{
    $_SESSION['response']['status'] = $status == null && has_body_key('status') ? $_SESSION['response']['status'] : $status;
    $_SESSION['response']['message'] = $message == null && has_body_key('message') ? $_SESSION['response']['message'] : $message;
    $_SESSION['response']['values'] = $values == null && has_body_key('values') ? $_SESSION['response']['values'] : $values;
    $_SESSION['response']['errors'] = $errors == null && has_body_key('errors') ? $_SESSION['response']['errors'] : $errors;
    $_SESSION['response']['data'] = $data == null && has_body_key('data') ? $_SESSION['response']['data'] : $data;
}

function has_body_key(string $key): bool
{
    return isset($_SESSION['response'][$key]) && !empty($_SESSION['response'][$key]);
}

function get_body(?string $key = null): array
{
    if (!is_null($key) && has_body_key($key)) {
        $result = $_SESSION['response'][$key] ?? [];
        unset($_SESSION['response'][$key]);
    } else {
        $result = session\get('response', true, []);
    }
    return $result;
}

function redirect(?string $url = null): void
{
    $path = $url ?? $_SERVER['HTTP_REFERER'] ?? '/';
    header("Location: {$path}");
    exit();
}