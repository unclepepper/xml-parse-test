<?php

declare(strict_types=1);

namespace Service;

use Database\Connection;
use Exception;

readonly class DesadvImportService
{


    public function __construct(
        private Connection $db,
        private array $data
    ) {}

    public function import(): void
    {
        try
        {
            // Вставка данных в таблицу
            $stmt = $this->db
                ->getConnection()
                ->prepare(
                    "INSERT INTO desadv (number, date, sender, recipient, body) VALUES (?, ?, ?, ?, ?)"
                );

            if(
                $stmt->execute([$this->data['number'], $this->data['date'], $this->data['sender'],
                    $this->data['recipient'], $this->data['body']])
            )
            {
                echo "\n Данные успешно загружены! \n\n";
            }
            else
            {
                echo "\n Ошибка при загрузке данных. \n\n";
            }
        }
        catch(Exception $e)
        {
            echo sprintf("Ошибка при вставке данных: %s", $e->getMessage());
        }
    }
}