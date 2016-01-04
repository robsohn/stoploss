<?php

namespace spec\AppBundle\Entity;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class StockSpec extends ObjectBehavior
{
    function it_increases_stop_loss_price()
    {
        $this->setStopLossMargin(4);
        $this->increaseStopLoss(10);
        $this->getStopLossPrice()->shouldBe(9.6);
    }
}
