<?php

namespace AppBundle\Service;


use Zttp\Zttp;

class FetchCurrencyPricesService
{
    private $currencyConverterService;

    public function __construct(CurrencyConverterService $currencyConverterService) {
        $this->currencyConverterService = $currencyConverterService;
    }

    public function getCurrencyRate($requiredCurrencies) {
        return $this->currencyConverterService->createMatrix($this->getRequest($requiredCurrencies));
    }

    private function getRequest($requiredCurrencies) {
        $cryptoCurrencies = $this->currencyConverterService->convert(\GuzzleHttp\json_decode($this->get('https://api.coinmarketcap.com/v1/ticker/?convert=UAH')), $requiredCurrencies);
        $currencies = $this->currencyConverterService->convert($this->get('https://bank.gov.ua/NBUStatService/v1/statdirectory/exchange'), $requiredCurrencies);
        return array_merge($cryptoCurrencies, $currencies, [['code' => 'UAH', 'rate' => 1]]);
    }

    public function getPair($requiredCurrencies) {
        if ($requiredCurrencies[0] === $requiredCurrencies[1]) return '1';
        $rate = $this->getRequest($requiredCurrencies);
        if (count($rate) < 2) return false;
        if (in_array('UAH', $requiredCurrencies)) {
            return ($requiredCurrencies[0] === 'UAH') ? $rate[0]['rate'] / $rate[1]['rate'] : $rate[1]['rate'] / $rate[0]['rate'];
        }
        return $rate[0]['rate'] / $rate[1]['rate'];
    }

    private function get($url) {
        return Zttp::get($url)->getBody()->getContents();
    }

}