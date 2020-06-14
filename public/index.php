<?php

session_start();

require_once __DIR__ . '/../bootstrap.php';
require_once __DIR__ . '/../routes.php';

$action = route();

require_once $action;

save_back();
