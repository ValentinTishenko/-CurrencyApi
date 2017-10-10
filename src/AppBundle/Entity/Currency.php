<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CurrencyRepository")
 * @ORM\Table(name="currency")
 */
class Currency
{

    /**
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $code;

    /**
     * @ORM\OneToMany(targetEntity="Rate", mappedBy="currency_id",indexBy="id",cascade={"persist"})
     * @var Rate[]
     */
    private $rates;

    /**
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getCode() {
        return $this->code;
    }

    /**
     * @param mixed $code
     */
    public function setCode($code) {
        $this->code = $code;
    }

    /**
     * @return mixed
     */
    public function getRates() {
        return $this->rates;
    }

    /**
     * @param mixed $rates
     */
    public function setRates($rates) {
        $this->rates = $rates;
    }

    /**
     * Currency constructor.
     * @param $code
     */
    public function __construct($code) {
        $this->rates = new ArrayCollection();
        $this->code = $code;
    }

}