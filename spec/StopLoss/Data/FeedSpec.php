<?php

namespace spec\StopLoss\Data;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FeedSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('StopLoss\Data\Feed');
    }
}
