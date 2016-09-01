<?php

namespace AppBundle\StockMarket\Data;


class Feed
{
    const EOD_STOCK_DATA_URL = '/pub/metastock/mstock/sesjaall/sesjaall.prn';

    const EOD_FUND_DATA_URL = '/pub/fundinwest/mstock/sesjafun/sesjafun.prn';

    private $client;

    public function __construct($client)
    {
        $this->client = $client;
    }

    public function fetch()
    {
        $csv = $this->fetchCsv(self::EOD_STOCK_DATA_URL) . $this->fetchCsv(self::EOD_FUND_DATA_URL);
        return $csv;
    }

    private function fetchCsv($uri)
    {
        $response = $this->client->get($uri);
        return $response->getBody()->__toString();
    }
}
