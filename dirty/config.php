<?php

function read_config(): void
{
    $options = parse_ini_file(config()['path']['base'] . '/config.ini', true);

    foreach ($options as $group => $configs) {
        config(['group' => $group, 'configs' => $configs]);
    }
}

function config(array $options = []): array
{
    static $config = [];

    if (!empty($options)) {
        $config[$options['group']] = $options['configs'];
    }

    return $config;
}
