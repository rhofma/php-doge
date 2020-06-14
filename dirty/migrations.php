<?php

function add(string $up, string $down): array
{
    $migration = [
        'up' => config()['path']['database'] . '/migrations/' . $up . '.sql',
        'down' => config()['path']['database'] . '/migrations/' . $down . '.sql',
    ];

    return migrations($migration);
}

function migrations(array $migration = []): array
{
    static $migrations = [];

    if (!empty($migration)) {
        $migrations[] = $migration;
    }

    return $migrations;
}

function migrate(string $file): void
{
    $sql = file_get_contents($file);

    if (empty($sql)) {
        return;
    }

    echo 'Migrating: ' . basename($file) . PHP_EOL;

    db()->exec($sql);
}

function all_up(): void
{
    $count = counter();
    $migrations = migrations();

    for ($i = $count; $i < count($migrations); $i++) {
        up();
    }
}

function all_down(): void
{
    $count = counter() - 1;

    for ($i = $count; $i >= 0; $i--) {
        down();
    }
}

function up(): void
{
    $count = counter();
    $migrations = migrations();

    if (isset($migrations[$count])) {
        migrate($migrations[$count]['up']);

        increment();
    }
}

function down(): void
{
    $count = counter() - 1;
    $migrations = migrations();

    if (isset($migrations[$count])) {
        migrate($migrations[$count]['down']);

        decriment();
    }
}

function increment(): void
{
    $count = counter();
    $count++;

    counter($count);
}

function decriment(): void
{
    $count = counter();
    $count--;

    counter($count);
}

function counter(int $count = -1): int
{
    $file = config()['path']['database'] . '/count';

    if (!file_exists($file)) {
        file_put_contents($file, 0);
    }

    if ($count > -1) {
        file_put_contents($file, $count);
    }

    return (int) file_get_contents($file);
}
