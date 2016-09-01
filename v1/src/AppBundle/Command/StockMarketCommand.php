<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use AppBundle\StockMarket\Data\Feed;
use AppBundle\StockMarket\Data\Filter;
use AppBundle\StockMarket\StockService;
use AppBundle\StockMarket\Observer;
use AppBundle\NotificationService;

class StockMarketCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('stock:analyse');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Fetch content');

        $feed = new Feed(
            $this->getContainer()->get('guzzle.client.bossa')
        );

        $service = new StockService(
            $feed, new Filter(), $this->getStocks()
        );

        $notifier = new NotificationService($this->getContainer()->get('mailer'));

        $observer = new Observer(
            $this->getContainer()->get('doctrine.orm.entity_manager'), $notifier
        );
        $service->attach($observer);
        $service->analyse();

        $output->writeln('Done.');
    }

    private function getStocks()
    {
        $stockRepository = $this->getContainer()->get('doctrine')->getRepository('AppBundle:Stock');
        return $stockRepository->findAll();
    }
}
