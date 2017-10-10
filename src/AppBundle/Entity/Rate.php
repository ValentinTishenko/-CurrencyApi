<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use DateTime;

/**
 * @ORM\Entity
 * @ORM\Table(name="rate")
 */
class Rate
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Currency", inversedBy="rates" )
     * @ORM\JoinColumn(name="currency_id", referencedColumnName="id")
     */
    private $currency_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $exchange_currency_id;

    /**
     * @ORM\Column(type="datetime")
     *
     */
    private $data;

    /**
     * @ORM\Column(type="float")
     */
    private $rate;

    /**
     * @return mixed
     */
    public function getCurrencyId() {
        return $this->currency_id;
    }

    /**
     * @param mixed $currency_id
     */
    public function setCurrencyId($currency_id) {
        $this->currency_id = $currency_id;
    }

    /**
     * @return mixed
     */
    public function getExchangeCurrencyId() {
        return $this->exchange_currency_id;
    }

    /**
     * @param mixed $exchange_currency_id
     */
    public function setExchangeCurrencyId($exchange_currency_id) {
        $this->exchange_currency_id = $exchange_currency_id;
    }

    /**
     * @return mixed
     */
    public function getData() {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data) {
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function getRate() {
        return $this->rate;
    }

    /**
     * @param mixed $rate
     */
    public function setRate($rate) {
        $this->rate = $rate;
    }


    /**
     * Rate constructor.
     * @param $currency_id
     * @param $exchange_currency_id
     * @param $rate
     */
    public function __construct($currency_id, $exchange_currency_id, $rate) {
        $this->currency_id = $currency_id;
        $this->exchange_currency_id = $exchange_currency_id;
        $this->rate = $rate;
        $this->data = new DateTime();
    }
}