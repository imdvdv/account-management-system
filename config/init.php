<?php

use core\session;

// TIMEZONE INIT
date_default_timezone_set(TIMEZONE);

// SESSION INIT
if (session_status() !== PHP_SESSION_ACTIVE) {
    ini_set('session.use_strict_mode', SESSION_SETTINGS['strict_mode']);
    ini_set('session.use_only_cookies', SESSION_SETTINGS['only_cookies']);
    session_set_cookie_params([
        'path' => SESSION_SETTINGS['path'],
        'httponly' => SESSION_SETTINGS['httponly'],
        'secure' => SESSION_SETTINGS['secure']
    ]);
    session_start();
} else {

    if (!session\check_regenerate()) {
        session\regenerate();
    }

}



