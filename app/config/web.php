<?php

/**
 * This config merge all config files
 */

$main = dirname(__FILE__);
$local = $main . '/local.php';
$main = $main . '/main.php';
$config = array_merge_recursive(
    is_file($main) ? require $main : array(),
    is_file($local) ? require $local : array(),
    [

    ]
);

return $config;