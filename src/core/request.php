<?php

namespace core\request;

function get_url(string $default = '/'): ?string
{
    return trim(urldecode($_SERVER['REQUEST_URI']), '/') ?? $default;
}

function get_parse_url(?string $url = null): ?array
{
    $url_data = null;
    $url = parse_url($url ?? get_url());
    $url_data['path'] = $url['path'] ?? null;

    if (isset($url['query'])) {
        parse_str($url['query'], $url_data['query']);
    }
    return $url_data;
}

function get_path(?string $uri = null): ?string
{
    $uri = $uri ?? get_url();
    $uri = parse_url($uri);
    return $uri['path'] ?? null;
}

function get_query_params(?string $url = null): ?array
{
    $url = $url ?? get_url();
    $url = parse_url($url);
    $result = null;

    if (isset($url['query']) && is_string($url['query'])) {
        parse_str($url['query'], $result);
    }

    return $result;
}

function get_method(): string
{
    return strtoupper($_POST['_method'] ?? $_SERVER['REQUEST_METHOD']);
}

function get_data(): array
{
    $result = [];
    $method = get_method();

    if ($method == 'POST' || $method == 'PUT' || $method == 'PATCH') {
        $request_data = array_merge($_POST, $_FILES);
    } elseif ($method == 'GET') {
        $request_data = $_GET;
    }

    foreach ($request_data as $key => $value) {
        $result[$key] = $value;
    }
    return $result;
}

function get_ip(): ?string
{
    return $_SERVER['HTTP_CLIENT_IP'] ?? $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? null;
}


