<?php
/**
 * Created by PhpStorm.
 * User: Valentyn_Tishchenko
 * Date: 9/26/2017
 * Time: 12:46 PM
 */

namespace AppBundle\Service;

use SimpleXMLElement;

class ParserService
{
    public function XMLParser($data, $requiredCurrencies) {
        $nodes = new SimpleXMLElement($data);
        $res = [];
        foreach ($nodes->currency as $currency) {
            if (in_array($currency->cc, $requiredCurrencies)) {
                array_push($res, ['code' => strval($currency->cc), 'rate' => strval($currency->rate)]);
            }
        }
        return $res;
    }

    public function parser($data, $requiredCurrencies) {
        return array_filter(array_map(function ($item) use ($requiredCurrencies) {
            if (in_array($item->symbol, $requiredCurrencies)) {
                return ['code' => strval($item->symbol), 'rate' => strval($item->price_uah)];
            }
        }, $data));
    }
}