<?php

declare(strict_types=1);

namespace Database;

use Exception;
use Parser\Env\EnvFileParser;
use PDO;
use PDOException;

class Connection
{
    private PDO $pdo;

    private EnvFileParser $connectionData;

    private string $dsn;

    /**
     * @throws Exception
     */
    public function __construct(EnvFileParser $connectionData)
    {
        $this->connectionData = $connectionData;
        $this->dnsGenerate();
        $this->connect();
    }

    /**
     * @throws Exception
     */
    private function connect(): void
    {
        try
        {
            $this->pdo = new PDO($this->dsn, $this->connectionData->username, $this->connectionData->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(PDOException $e)
        {
            throw new Exception(sprintf("Ошибка подключения к базе данных: %s", $e->getMessage()));
        }
    }

    public function getConnection(): PDO
    {
        return $this->pdo;
    }

    public function dnsGenerate(): static
    {
        $this->dsn = sprintf(
            'mysql:host=%s;dbname=%s;charset=utf8',
            $this->connectionData->host,
            $this->connectionData->database
        );

        return $this;
    }
}