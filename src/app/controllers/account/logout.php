<?php

use core\session;
use core\cookie;
use core\response;

if (cookie\has('token')) {
    cookie\remove('token');
}

session\remove('user');
response\redirect('/login');