<?php


namespace AppBundle\Repository;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping;
use AppBundle\Entity\Currency;
use AppBundle\Entity\Rate;
use DateTime;

class CurrencyRepository extends EntityRepository
{

    /**
     * @param $codes string
     * @param $period string
     * @return mixed
     */
    public function getCurrencyRatesForPeriod($codes, $period) {
        $currency = $this->getCurrencyByCode($codes[0]);
        $exchangeCurrency = $this->getCurrencyByCode($codes[1]);
        return $currency->getRates()
            ->filter(function (Rate $rate) use ($period, $exchangeCurrency) {
                return $rate->getData() > new DateTime($period) && $rate->getExchangeCurrencyId() === $exchangeCurrency->getId();
            });
    }

    public function getCurrencyByCode($code) {
        $currency = $this->findOneBy(['code' => $code]);
        if (!$currency) {
            return $this->create($code);
        }
        return $currency;
    }

    public function create($code) {
        $currency = new Currency($code);
        $this->flush($currency);
        return $currency;
    }

    public function addRate($codes, $rate) {
        $currency = $this->getCurrencyByCode($codes[0]);
        $exchangeCurrency = $this->getCurrencyByCode($codes[1]);
        $currency->getRates()->add(new Rate($currency, $exchangeCurrency->getId(), $rate));
        $this->flush($currency);
    }

    public function flush($currency) {
        $this->_em->persist($currency);
        $this->_em->flush();
    }
}