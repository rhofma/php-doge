<?php

function db(): ?PDO
{
    static $db = null;

    $config = config()['db'];

    if (is_null($db)) {
        try {
            $options = config()['app']['debug'] ? [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION] : [];

            $db = new PDO(
                'mysql:host=' . $config['host'] . ';dbname=' . $config['database'],
                $config['user'],
                $config['password'],
                $options
            );
        } catch (PDOException $e) {
            dump($e->getMessage());
        }
    }

    return $db;
}

function sql(string $sql, array $params): array
{
    try {
        $statement = db()->prepare($sql);

        $result = $statement->execute($params);
    } catch (PDOException $e) {
        die($e->getMessage());
    }

    return compact('statement', 'result');
}

function find(string $table, int $id): array
{
    return select($table, 'WHERE id = :id', compact('id'))[0];
}

function find_by_slug(string $table, string $slug): array
{
    return select($table, 'WHERE slug LIKE :slug', compact('slug'))[0];
}

function select(string $table, string $where = '', array $params = [], bool $pagination = false): array
{
    $page = page();
    $perPage = config()['app']['per-page'];
    $offset = ($page - 1) * $perPage;

    $limit = $pagination ? ' LIMIT ' . $offset . ', ' . $perPage : '';

    $sql = 'SELECT * FROM ' . $table . ' ' . $where . $limit;

    $statement = sql($sql, $params)['statement'];
    $items = $statement->fetchAll();

    if ($pagination) {
        $sql = 'SELECT count(*) AS total FROM ' . $table . ' ' . $where;
        $statement = sql($sql, $params)['statement'];
        $total = (int) $statement->fetchColumn();
        $lastPage = (int) ceil($total / $perPage);

        return compact('items', 'total', 'lastPage');
    }

    return $items;
}

function page(int $page = 0): int
{
    static $current = 1;

    if ($page === 0 && isset($_REQUEST['page'])) {
        $current = $_REQUEST['page'];
    }

    if ($page > 0) {
        $current = $page;
    }

    return $current;
}

function insert(string $table, array $params, bool $timestamps = false): bool
{
    if ($timestamps) {
        $now = date('Y-m-d H:i:s');
        $params['created_at'] = $now;
        $params['updated_at'] = $now;
    }

    $keys = array_keys($params);

    $sql = 'INSERT INTO ' . $table . ' (';
    foreach ($keys as $key) {
        $sql .= '`' . $key . '`, ';
    }

    $sql = rtrim(trim($sql), ',');
    $sql .= ') VALUES (';

    foreach ($keys as $key) {
        $sql .= ':' . $key . ', ';
    }

    $sql = rtrim(trim($sql), ',');
    $sql .= ')';

    return sql($sql, $params)['result'];
}

function update(string $table, int $id, array $params, bool $timestamp = false): bool
{
    if ($timestamp) {
        $params['updated_at'] = date('Y-m-d H:i:s');
    }

    $keys = array_keys($params);

    $sql = 'UPDATE ' . $table . ' SET ';

    foreach ($keys as $key) {
        $sql .= '`' . $key . '` = :' . $key . ', ';
    }

    $sql = rtrim(trim($sql), ',');

    $sql .= ' WHERE id = :id';

    $params['id'] = $id;

    return sql($sql, $params)['result'];
}

function destroy(string $table, int $id): bool
{
    $sql = 'DELETE FROM ' . $table . ' WHERE id = :id';
    $params = ['id' => $id];

    return sql($sql, $params)['result'];
}

function slug(string $string): string
{
    $string = preg_replace(
        ["#ä#", "#ü#", "#ö#", "#ß#", "#Ä#", "#Ü#", "#Ö#"],
        ["ae", "ue", "oe", "ss", "Ae", "Ue", "Oe"],
        $string
    );

    $string = preg_replace("#[^a-z0-9\\-_]#i", "-", $string);
    $string = preg_replace("#[\\-]+#i", "-", $string);
    $string = trim($string, "-");

    if (!trim($string)) {
        $string = "-";
    }

    return $string;
}

function action(callable $callback, string $message = 'wow done', string $error = 'nope such sorry'): void
{
    $callback() ? message($message) : errors([$error]);
}
