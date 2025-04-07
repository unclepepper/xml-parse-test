<?php


use Database\Connection;
use Parser\Env\EnvFileParser;
use Parser\Xml\XmlFileParser;
use Service\DesadvImportService;


$xmlFile = dirname(__DIR__) . '/desadv_1111.xml';
$constVariable = require  dirname(__DIR__) . '/config/const.php';
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

    $xmlParser = new XmlFileParser($xmlFile);

    $import = new DesadvImportService($database, $xmlParser->getData());

    $import->import();
}
catch(Exception $e)
{
    echo sprintf("Ошибка: %s", $e->getMessage());
}