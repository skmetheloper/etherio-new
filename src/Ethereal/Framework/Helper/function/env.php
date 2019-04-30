<?php

function env(string $variable, $is_null = null)
{
    if ($return = getenv($variable) ?? false)
        return $return;

    if ($return = $_ENV[$variable] ?? false)
        $return = $_SERVER[$variable];

    if ($return = ini_get($variable) ?? false)
        return $return;

    return $is_null;
}
