<?php

declare(strict_types=1);

namespace Parser;

use Exception;

abstract class AbstractParser
{
    /**
     * @throws Exception
     */
    public function __construct(protected string $parseFile)
    {
        $this->loadFile();
    }

    /**
     * @throws Exception
     */
    protected function loadFile(): void
    {
        if(!file_exists($this->parseFile))
        {
            throw new Exception(sprintf("Файл не найден: %s", $this->parseFile));
        }
        $this->parse();
    }


    abstract protected function parse();

}