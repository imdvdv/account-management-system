<?php

$valid_id = '[1-9]+\d*';
$query_params = '\?[a-zA-Z0-9]+(=[a-zA-Z0-9]+)?(&[a-zA-Z0-9]+(=[a-zA-Z0-9]+)?)*';

return [

    // PAGES
    '/^\/?$/' => [
        'method' => 'GET',
        'controller' => 'page/profile',
        'middleware' => ['auth']
    ],
    '/^profile\/?$/' => [
        'method' => 'GET',
        'controller' => 'page/profile',
        'middleware' => ['auth']
    ],
    '/^login\/?$/' => [
        'method' => 'GET',
        'controller' => 'page/login',
        'middleware' => ['guest']
    ],
    '/^signup\/?$/' => [
        'method' => 'GET',
        'controller' => 'page/signup',
        'middleware' => ['guest']
    ],
    '/^forgot\/?$/' => [
        'method' => 'GET',
        'controller' => 'page/forgot',
        'middleware' => ['guest']
    ],
    '/^recovery($query_params)?$/' => [
        'method' => 'GET',
        'controller' => 'page/recovery'
    ],

    // ACCOUNT ACTIONS
    '/^auth\/?$/' => [
        'method' => 'POST',
        'controller' => 'account/auth_by_password',
        'middleware' => ['guest']
    ],
    '/^auth\/token\/?$/' => [
        'method' => 'GET',
        'controller' => 'account/auth_by_token',
    ],
    '/^register\/?$/' => [
        'method' => 'POST',
        'controller' => 'account/register',
        'middleware' => ['guest']
    ],
    '/^request-recovery\/?$/' => [
        'method' => 'POST',
        'controller' => 'account/request_recovery',
    ],
    '/^profile\/reset-sessions\/?$/' => [
        'method' => 'DELETE',
        'controller' => 'account/reset_sessions',
        'middleware' => ['auth']
    ],
    '/^profile\/recovery-access\/?$/' => [
        'method' => 'PATCH',
        'controller' => 'account/recovery_access'
    ],
    '/^profile\/avatar\/edit\/?$/' => [
        'method' => 'PATCH',
        'controller' => 'account/update_avatar',
        'middleware' => ['auth']
    ],
    '/^profile\/avatar\/delete\/?$/' => [
        'method' => 'DELETE',
        'controller' => 'account/remove_avatar',
        'middleware' => ['auth']
    ],
    '/^profile\/edit\/?$/' => [
        'method' => 'PATCH',
        'controller' => 'account/update_data',
        'middleware' => ['auth']
    ],
    '/^profile\/delete\/?$/' => [
        'method' => 'DELETE',
        'controller' => 'account/remove',
        'middleware' => ['auth']
    ],
    '/^logout\/?$/' => [
        'method' => 'DELETE',
        'controller' => 'account/logout',
        'middleware' => ['auth']
    ],

    // POPUPS
    '/^popup\/upload-avatar\/?$/' => [
        'method' => 'GET',
        'controller' => 'popup/upload_avatar',
        'middleware' => ['allowed_referer', 'auth']
    ],
    '/^popup\/reset-sessions\/?$/' => [
        'method' => 'GET',
        'controller' => 'popup/reset_sessions',
        'middleware' => ['allowed_referer', 'auth']
    ],
    '/^popup\/delete-profile\/?$/' => [
        'method' => 'GET',
        'controller' => 'popup/delete_profile',
        'middleware' => ['allowed_referer', 'auth']
    ],

    // ERRORS
    '/^403\/?$/' => [
        'method' => 'GET',
        'controller' => 'errors/403'
    ],
    '/^404\/?$/' => [
        'method' => 'GET',
        'controller' => 'errors/404'
    ],
    '/^500\/?$/' => [
        'method' => 'GET',
        'controller' => 'errors/500'
    ],
];