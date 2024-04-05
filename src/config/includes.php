<?php

// INCLUDE CONFIG
include_once "{$_SERVER["DOCUMENT_ROOT"]}/src/config/env.php";

// INCLUDE FUNCTIONS FOR AUTHORIZATION CHECK
include_once "{$_SERVER["DOCUMENT_ROOT"]}/src/helpers/db-connection.php";
include_once "{$_SERVER["DOCUMENT_ROOT"]}/src/helpers/validation.php";
include_once "{$_SERVER["DOCUMENT_ROOT"]}/src/helpers/get-random-code-data.php";
include_once "{$_SERVER["DOCUMENT_ROOT"]}/src/helpers/auth-by-token.php";
include_once "{$_SERVER["DOCUMENT_ROOT"]}/src/helpers/is-authorized.php";


