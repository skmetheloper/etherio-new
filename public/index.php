<?php

require_once __DIR__ . '/../build/autoload.php';

$server->get_config('application');
$server->get_config('environment');

// echo '<pre>';print_r(get_defined_vars());
echo '<pre>', json_encode([
    'server' => $_SERVER,
    'env' => $_ENV,
    'cli:cgi' => get_class($server),
    '_' => $server
]);
