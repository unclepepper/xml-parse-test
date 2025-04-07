<?php


use Database\Connection;
use Parser\Env\EnvFileParser;


$constVariable = require dirname(__DIR__).'/config/const.php';
$envFile = $constVariable['ENV_PATH'];

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

    $data = $database->getConnection()->query('SELECT * FROM desadv');


    var_dump($data->fetchAll());


}
catch(Exception $e)
{
    echo sprintf("Ошибка: %s", $e->getMessage());
}