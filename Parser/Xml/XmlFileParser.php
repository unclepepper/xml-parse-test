<?php

declare(strict_types=1);

namespace Parser\Xml;

use Parser\AbstractParser;
use SimpleXMLElement;

class XmlFileParser extends AbstractParser
{
    private false|SimpleXMLElement $xml;

    protected function parse(): void
    {
        $this->xml = simplexml_load_file($this->parseFile);
    }

    public function getData(): array
    {
        return [
            'number' => (string) $this->xml->NUMBER,
            'date' => (string) $this->xml->DATE,
            'sender' => (string) $this->xml->HEAD->SENDER,
            'recipient' => (string) $this->xml->HEAD->RECIPIENT,
            'body' => $this->getBodyData()
        ];
    }

    private function getBodyData(): false|string
    {
        $bodyArray = [];

        foreach($this->xml->HEAD->PACKINGSEQUENCE->POSITION as $position)
        {
            $positionData = [];
            foreach($position as $key => $value)
            {
                $positionData[$key] = (string) $value;
            }
            $bodyArray[] = $positionData; // Добавляем данные позиции в массив
        }

        return json_encode($bodyArray); // Преобразуем массив позиций в JSON
    }
}