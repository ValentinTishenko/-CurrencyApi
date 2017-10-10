<?php
/**
 * Created by PhpStorm.
 * User: Valentyn_Tishchenko
 * Date: 10/5/2017
 * Time: 11:52 AM
 */

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Rate;

class RateRepository extends EntityRepository
{
    public function create($currency_id, $exchange_currency_id, $data, $rate) {
        $rate = new Rate($currency_id, $exchange_currency_id, $data, $rate);
        $this->_em->persist($rate);
        $this->_em->flush();
        return $rate;
    }

    public function save() {

    }
}