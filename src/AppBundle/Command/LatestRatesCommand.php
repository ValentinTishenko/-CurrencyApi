<?php

namespace AppBundle\Command;

use AppBundle\Service\FetchCurrencyPricesService;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class LatestRatesCommand extends Command
{
    private $fetchCurrencyPricesService;

    public function __construct($name = null, FetchCurrencyPricesService $fetchCurrencyPricesService) {
        parent::__construct($name);
        $this->fetchCurrencyPricesService = $fetchCurrencyPricesService;
    }

    protected function configure() {
        $this
            ->setName('app:latest-rates')
            ->setDescription('show latest rates')
            ->setHelp('This command allows you to show latest rates...');
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $matrix = $this->fetchCurrencyPricesService->getCurrencyRate(false);
        $header = array_map(function ($item) {
            return $item[0];
        }, $matrix);
        array_unshift($header, 'currancy');
        $table = new Table($output);
        $table
            ->setHeaders($header)
            ->setRows($matrix);
        $table->render();
    }
}