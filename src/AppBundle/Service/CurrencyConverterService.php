<?php
/**
 * Created by PhpStorm.
 * User: Valentyn_Tishchenko
 * Date: 9/26/2017
 * Time: 11:43 AM
 */

namespace AppBundle\Service;


class CurrencyConverterService
{
    private $requiredCurrencies;
    private $parserService;

    public function __construct(ParserService $parserService) {
        $this->requiredCurrencies = ['BTC', 'ETH', 'RUB', 'USD', 'UAH', 'PLN', 'CAD'];
        $this->parserService = $parserService;
    }


    public function convert($data, $requiredCurrencies) {
        $this->requiredCurrencies = ($requiredCurrencies) ? $requiredCurrencies : $this->requiredCurrencies;
        return (gettype($data) === 'string') ? $this->parserService->XMLParser($data, $this->requiredCurrencies) : $this->parserService->parser($data, $this->requiredCurrencies);
    }

    public function createMatrix($data) {
        $matrix = [];
        $len = count($data);
        for ($i = 0; $i < $len; $i++) {
            $matrix[$i][0] = $data[$i]['code'];
            for ($j = 0; $j < $len; $j++) {
                $matrix[$i][$j + 1] = $data[$j]['rate'] / $data[$i]['rate'];
            }
        }
        return $matrix;
    }
}