<?php

$constVariable = require dirname(__DIR__).'/config/const.php';
$envFile = $constVariable['ENV_PATH'];

use Database\Connection;
use Parser\Env\EnvFileParser;

spl_autoload_register(function($class) {

    $path = str_replace('\\', '/', __DIR__.'/../'.$class.'.php');

    if(file_exists($path))
    {

        require $path;
    }
});


try
{
    $database = new Connection(new EnvFileParser($envFile));

    $database->getConnection()->query(
        "CREATE TABLE desadv (
                id INT AUTO_INCREMENT PRIMARY KEY,
                number VARCHAR(255) UNIQUE NOT NULL,
                date DATE,
                sender VARCHAR(255),
                recipient VARCHAR(255),
                body TEXT
            );"
    );

    echo "\n Таблица успешно создана \n\n";

}
catch(Exception $e)
{
    echo sprintf("\n Ошибка: %s  \n\n", $e->getMessage());
}