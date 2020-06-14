<?php

function dd($var): void
{
    dump($var);
    die();
}

function dump($var): void
{
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
}

function error(int $code, string $text = ''): void
{
    header($text, true, $code);
    die($text);
}

function error404(): void
{
    header('Not Found', true, 404);
    error_page('404');
}

function error401(): void
{
    header('Authorization Required', true, 401);
    header('WWW-Authenticate: Basic realm="Access denied"');
    error_page('401');
}

function error_page(string $view = 'default'): void
{
    render('errors/' . $view);
    die();
}

function register_error_handler(): void
{
    $debug = (bool) config()['app']['debug'];

    if ($debug) {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        return;
    }

    error_reporting(E_ALL);
    ini_set('display_errors', 'off');

    set_error_handler('error_handler');
    register_shutdown_function('die');
    set_exception_handler('eception_handler');
}

function error_handler(int $errno = 0, string $errstr = ''): bool
{
    error_page();

    return true;
}

function exception_handler(Exception $e): void
{
    error_page();
}
