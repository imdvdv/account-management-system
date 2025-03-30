<?php

namespace core\session;

use core\helpers;

function check_regenerate(): bool
{   
    return isset($_SESSION['regenerate']['expiration_time']) && is_int($_SESSION['regenerate']['expiration_time']) && $_SESSION['regenerate']['expiration_time'] > time();
}

function regenerate(int $term = ONE_HOUR): void
{   
    if (session_regenerate_id()) {
        $_SESSION['regenerate']['expiration_time'] = time() + $term; 
    } else {
        helpers\write_to_log('Failed regenerate session id', __FILE__);
    }
}

function set(string $key, mixed $value): void
{   
    $_SESSION[$key] = $value;
    regenerate();
}

function has(string $key): bool
{   
    return isset($_SESSION[$key]);
}

function remove(string $key): void
{
    unset($_SESSION[$key]);
    regenerate();
}

function get(string $key, bool $destroy = false, mixed $default = null): mixed
{
    $result = $_SESSION[$key] ?? $default;

    if ($destroy) {
        remove($key); 
    }
    return $result;
}

function set_temp_content(array $content_data): void
{   
    set('temp_content', $content_data);
}

function get_temp_content(): array
{   
    return get('temp_content', true, []);
}

function set_user(int $id, string $token, string $email, ?string $name = null, ?string $avatar = null): void
{   
    set('user', [
        'id' => $id,
        'token' => $token,
        'email' => $email,
        'name' => $name,
        'avatar' => $avatar
    ]);
}

function update_user_data(array $data): void
{   
    foreach ($data as $key => $value) {
        if (array_key_exists($key, $_SESSION['user'])) {
            $_SESSION['user'][$key] = $value;
        } 
    }
    regenerate();
}

function has_user(?string $key = null): bool
{   
    if (is_string($key)) {
        return isset($_SESSION['user'][$key]) && !empty($_SESSION['user'][$key]);
    }
    return isset($_SESSION['user']['id'], $_SESSION['user']['token'], $_SESSION['user']['email']) && helpers\is_id($_SESSION['user']['id']) && helpers\is_email($_SESSION['user']['email']);
}

function get_user(?string $key = null): mixed
{   
    return is_null($key) ? get('user') : $_SESSION['user'][$key] ?? null;
}

function set_reset(int $code_id, string $code): void
{   
    set('reset', [
        'code_id' => $code_id,
        'code' => $code,
    ]);
}

function has_reset(?string $key = null): bool 
{
    if (is_string($key)) {
        return isset($_SESSION['reset'][$key]) && !empty($_SESSION['reset'][$key]);
    }
    return isset($_SESSION['reset']['code'], $_SESSION['reset']['code_id']) && helpers\is_code($_SESSION['reset']['code']) && helpers\is_id($_SESSION['reset']['code_id']);
}

function get_reset(?string $key = null): array|string
{
    return is_null($key) ? get('reset') : $_SESSION['reset'][$key] ?? null;
}
