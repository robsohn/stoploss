<?php
/**
 * Created by PhpStorm.
 * User: rraszczynski
 * Date: 23/12/15
 * Time: 14:51
 */

namespace AppBundle\StockMarket;

use \AppBundle\StockMarket\Data\Feed;
use \AppBundle\StockMarket\Data\Filter;
use \AppBundle\Entity\Stock;
use \AppBundle\StockMarket\Observer;

class StockService
{
    private $stockCollection;

    private $feed;

    private $dataFilter;

    private $listener = null;

    public function __construct(Feed $feed, Filter $filter, $stockCollection)
    {
        $this->feed = $feed;
        $this->dataFilter = $filter;
        $this->stockCollection = $stockCollection;
    }

    public function analyse()
    {
        $csv = $this->feed->fetch();
        $this->dataFilter->filter($csv);

        foreach ($this->stockCollection as $stock) {
            $this->analyseStockData($stock);
        }
    }

    public function attach(Observer $observer)
    {
        $this->listener = $observer;
    }

    private function analyseStockData(Stock $stock)
    {
echo "Processing {$stock->getCode()} \n";
        $data = $this->dataFilter->getDataByCode($stock->getCode());

        if ($this->isPriceLowerThanStopLoss($data['close'], $stock->getStopLossPrice())) {
            $this->listener->onSell($stock);
        } elseif ($this->isPriceGreaterThanStopLossBase($data['close'], $stock->getStopLossBase())) {
            $this->listener->onIncreaseStopLoss($stock, $data);
        }
    }

    private function isPriceLowerThanStopLoss($price, $stopLoss)
    {
echo "isPriceLowerThanStopLoss: $price < $stopLoss\n";
        return $price < $stopLoss;
    }

    private function isPriceGreaterThanStopLossBase($price, $stopLossBase)
    {
echo "isPriceGreaterThanStopLossBase: $price > $stopLossBase\n";
        return $price > $stopLossBase;
    }
}