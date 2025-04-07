<?php

$constVariable = require  dirname(__DIR__) . '/config/const.php';
$envFile = $constVariable['ENV_PATH'];

use Database\Connection;
use Parser\Env\EnvFileParser;

spl_autoload_register(function($class) {

    $path = str_replace('\\', '/', __DIR__. '/../'.$class.'.php');

    if (file_exists($path)) {

        require $path;
    }
});


try {
    $database = new Connection(new EnvFileParser($envFile));

    $database->getConnection()->query('drop table desadv;');

    echo " \n Таблица успешно удалена  \n\n";
} catch (Exception $e) {
    echo sprintf(" \n Ошибка: %s  \n\n", $e->getMessage());
}