<?php

function route(): ?string
{
    check_ie();

    $path = parse_url($_SERVER['REQUEST_URI'])['path'];

    $method = $_REQUEST['_method'] ?? $_SERVER['REQUEST_METHOD'];
    $matched = matching(strtoupper($method), $path);

    if (is_null($matched)) {
        error404();
    }

    return config()['path']['actions'] . '/' . $matched . '.php';
}

function check_ie(): void
{
    $ua = htmlentities($_SERVER['HTTP_USER_AGENT'], ENT_QUOTES, 'UTF-8');
    if (preg_match('~MSIE|Internet Explorer~i', $ua) || (strpos($ua, 'Trident/7.0; rv:11.0') !== false)) {
        error_page('ie');
    }
}

function matching(string $method, string $path): ?string
{
    $routes = routes();

    if (!isset($routes[$method])) {
        return null;
    }

    foreach ($routes[$method] as $route) {
        if (preg_match($route['pattern'], $path, $vars)) {
            array_shift($vars);
            $vars = array_values($vars);

            foreach ($route['params'] as $index => $param) {
                params(['key' => $param, 'value' => $vars[$index]]);
            }

            return $route['action'];
        }
    }

    return null;
}

function params(array $param = []): array
{
    static $params = [];

    if (!empty($param)) {
        $params[$param['key']] = $param['value'];
    }

    return $params;
}

function routes(array $route = []): array
{
    static $routes = [];

    if (!empty($route)) {
        $routes[$route['method']][] = $route;
    }

    return $routes;
}

function request(string $method, string $pattern, string $action, array $params = []): array
{
    $pattern = '/^' . str_replace('/', '\/', $pattern) . '$/';

    return routes(compact('method', 'pattern', 'action', 'params'));
}

function get(string $pattern, string $action, array $params = []): array
{
    return request('GET', $pattern, $action, $params);
}

function post(string $pattern, string $action, array $params = []): array
{
    return request('POST', $pattern, $action, $params);
}

function put(string $pattern, string $action, array $params = []): array
{
    return request('PUT', $pattern, $action, $params);
}

function patch(string $pattern, string $action, array $params = []): array
{
    return request('PATCH', $pattern, $action, $params);
}

function delete(string $pattern, string $action, array $params = []): array
{
    return request('DELETE', $pattern, $action, $params);
}
