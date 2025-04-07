<?php

declare(strict_types=1);

namespace Parser\Env;

use Parser\AbstractParser;

class EnvFileParser extends AbstractParser
{

    public string $host {
        get {
            return $this->host;
        }
    }
    public string $database {
        get {
            return $this->database;
        }
    }

    public string $username {
        get {
            return $this->username;
        }
    }
    public string $password {
        get {
            return $this->password;
        }
    }


    protected function parse(): void
    {
        $this->database = $this->getParam("DB_DATABASE");
        $this->host = $this->getParam("DB_HOST");
        $this->username = $this->getParam('DB_USERNAME');
        $this->password = $this->getParam('DB_PASSWORD');
    }

    public function getParam(string $param): false|string
    {

        $param = trim($param.'=');
        $fp = fopen($this->parseFile, 'r');
        while(($line = fgets($fp)) !== false)
        {
            if(preg_match("~.*\b$param(.*)~", $line, $matches))
            {
                return $matches[1];
            }
        }
        return false;
    }

}