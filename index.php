<?php

/* Define environment */
CONST DEVELOPMENT_ENVIRONMENT = true;

// Var folder that contains log files
const LOG_PATH = 'application/var/log/';

error_reporting(E_ALL);
if (DEVELOPMENT_ENVIRONMENT) {
    ini_set('display_errors', 'On');
} else {
    ini_set('display_errors', 'Off');
    ini_set('log_errors', 'On');
    ini_set('error_log', LOG_PATH . 'error.log');
}

require __DIR__ . '/vendor/autoload.php';

Eric\Core\Framework::run();

