<?php
/**
 * Created by PhpStorm.
 * User: rraszczynski
 * Date: 23/12/15
 * Time: 16:26
 */

namespace AppBundle\StockMarket;

use \AppBundle\Entity\Stock;
use \AppBundle\NotificationService;

class Observer
{
    private $entityManager;

    private $notificationService;

    public function __construct($entityManager, NotificationService $notificationService)
    {
        $this->entityManager = $entityManager;
        $this->notificationService = $notificationService;
    }

    public function onSell(Stock $stock)
    {
        $this->notificationService->notifyOnSell($stock);
    }

    public function onIncreaseStopLoss(Stock $stock, array $feedData)
    {
        $stock->increaseStopLoss($feedData['close']);
        $this->entityManager->persist($stock);
        $this->entityManager->flush();

        $this->notificationService->notifyOnIncreaseStopLoss($stock);
    }
}