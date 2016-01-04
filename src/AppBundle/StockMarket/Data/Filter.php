<?php
/**
 * Created by PhpStorm.
 * User: rraszczynski
 * Date: 15/12/15
 * Time: 15:53
 */

namespace AppBundle\StockMarket\Data;


class Filter
{
    private $parsedCsv;

    private $columnMap = [
        'code',
        'date',
        'open',
        'max',
        'min',
        'close',
        'volume'
    ];

    public function __construct()
    {
        $this->parsedCsv = new \ArrayObject();
    }

    public function filter($csv)
    {
        $splitCsvData = explode("\n", $csv);

        foreach ($splitCsvData as $csvLine) {
            if (strlen($csvLine) > 0) {
                $csvLineArray = str_getcsv($csvLine);
                $this->parsedCsv[$csvLineArray[0]] = $csvLineArray;
            }
        }
    }

    public function getDataByCode($code)
    {
        if ($this->parsedCsv->offsetExists($code)) {
            return $this->mapColumns($code);
        }

        return null;
    }

    private function mapColumns($code)
    {
        $data = $this->parsedCsv->offsetGet($code);
        $mappedData = [];
        foreach ($this->columnMap as $index => $name) {
            $mappedData[$name] = $data[$index];
        }
var_dump($mappedData);
        return $mappedData;
    }
}