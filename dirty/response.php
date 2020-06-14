<?php

function render(string $view, array $data = []): void
{
    echo template($view, $data);
}

function template(string $view, array $data = []): string
{
    extract($data);

    ob_start();

    include config()['path']['views'] . '/' . $view . '.php';

    return ob_get_clean();
}

function json(array $data): void
{
    header('Content-Type: application/json');
    echo json_encode($data);
}

function cors(string $origin = '*'): void
{
    header('Access-Control-Allow-Origin: ' . $origin);
}

function redirect($target): void
{
    header('Location: ' . $target);
}

function back(): void
{
    redirect($_SESSION['_back']);
}

function save_back()
{
    $_SESSION['_back'] = $_SERVER['REQUEST_URI'];
}

function has_message(): bool
{
    return isset($_SESSION['_message']);
}

function message(string $text = ''): string
{
    if (!empty($text)) {
        $_SESSION['_message'] = $text;
        return $text;
    }

    $text = has_message() ? $_SESSION['_message'] : '';
    unset($_SESSION['_message']);

    return $text;
}

function e(string $text): string
{
    return htmlspecialchars($text);
}

function asset(string $file): string
{
    return $file . '?' . @filemtime(config()['path']['public'] . '/' . $file);
}

function title(?string $title = null): string
{
    static $pageTitle = 'yolo';

    $pageTitle = $title ?? $pageTitle;

    return $pageTitle;
}

function honeypot(): string
{
    $now = base64_encode(time());

    $html = '<div class="my-name-wrap" style="display:none;">';
    $html .= '<input type="text" name="my_name" value id="my_name">';
    $html .= '<input type="text" name="my_time" value="' . $now . '">';
    $html .= '</div>';

    return $html;
}

function fu(): void
{
    if (
        time() - base64_decode($_REQUEST['my_time']) > 5
        && empty($_REQUEST['my_name'])
    ) {
        return;
    }

    header('Forbidden', true, 403);
    error_page('fu-bot');
}
