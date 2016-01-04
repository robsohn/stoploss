<?php
/**
 * Created by PhpStorm.
 * User: rraszczynski
 * Date: 04/01/16
 * Time: 15:03
 */

namespace AppBundle;

use \AppBundle\Entity\Stock;

class NotificationService
{
    private $mailer;

    public function __construct($mailer)
    {
        $this->mailer = $mailer;
    }

    public function notifyOnSell(Stock $stock)
    {
echo "SELL \n";
        $message = $this->createMessage('SPRZEDAJ', 'Sprzedaj ' . $stock->getCode());
        $this->mailer->send($message);
    }

    public function notifyOnIncreaseStopLoss(Stock $stock)
    {
echo "Stop Loss Updated \n";
        $text = $stock->getCode() . ' StopLoss zwiększony do: ' . $stock->getStopLossPrice();
        $message = $this->createMessage('Stop Loss zmienione', $text);
        $this->mailer->send($message);
    }

    private function createMessage($subject, $text)
    {
        return \Swift_Message::newInstance()
            ->setSubject('Stop Loss notification - ' . $subject)
            ->setFrom('raszczynski@gmail.com')
            ->setTo('raszczynski@gmail.com')
            ->setBody($text, 'text/plain');
    }
}