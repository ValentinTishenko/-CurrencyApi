<?php

namespace AppBundle\Command;

use AppBundle\Service\CurrencyConverterService;
use AppBundle\Service\CurrencyService;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\TableSeparator;
use Symfony\Component\Console\Input\InputArgument;
use AppBundle\Service\FetchCurrencyPricesService;

class CurrencyPairCommand extends Command
{


    private $fetchCurrencyPricesService;

    public function __construct($name = null, FetchCurrencyPricesService $fetchCurrencyPricesService) {
        parent::__construct($name);
        $this->fetchCurrencyPricesService = $fetchCurrencyPricesService;
    }

    protected function configure() {
        $this
            ->setName('app:currency-pair')
            ->addArgument('currency pair', InputArgument::REQUIRED, 'currency pair')
            ->setDescription('show currency pair')
            ->setHelp('This command allows you to get rate for currency pair...');
    }

    public function execute(InputInterface $input, OutputInterface $output) {
        $output->writeln('currency pair: ' . $this->fetchCurrencyPricesService->getPair(explode('-', $input->getArgument('currency pair'))));
    }
}