<?php

function auth(): void
{
    header('Cache-Control: no-cache, must-revalidate, max-age=0');

    if (!authenticated()) {
        error401();
    }
}

function authenticated(): bool
{
    $auth = config()['auth'];

    return (isset($_SERVER['PHP_AUTH_USER']) && $_SERVER['PHP_AUTH_USER'] === $auth['user'])
        && (isset($_SERVER['PHP_AUTH_PW']) && $_SERVER['PHP_AUTH_PW'] === $auth['password']);
}
