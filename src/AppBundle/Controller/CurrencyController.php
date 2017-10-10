<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Rate;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Currency;
use AppBundle\Service\CacheService;
use AppBundle\Service\FetchCurrencyPricesService;
use GuzzleHttp\Psr7\Response;
use Symfony\Component\HttpFoundation\Request;


class CurrencyController extends Controller
{
    private $cacheService;
    private $fetchCurrencyPricesService;

    public function __construct(FetchCurrencyPricesService $fetchCurrencyPricesService, CacheService $cacheService) {
        $this->cacheService = $cacheService;
        $this->fetchCurrencyPricesService = $fetchCurrencyPricesService;
    }

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request) {
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')) . DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @param string $param
     * @Route("/test/{param}", name="homepage2")
     */
    public function getPair($param) {
        $cache = $this->cacheService->getCache($param);
        if ($cache) {
            foreach ($cache as $item) {
                dump($item->getRate());
            }
            exit('cache is exist');
        } else {
            $codes = explode('-', $param);
            $rateValue = $this->fetchCurrencyPricesService->getPair($codes);
            if ($rateValue) {
                $repo = $this->getDoctrine()->getManager()->getRepository(Currency::class);
                $repo->addRate($codes, $rateValue);
                $rates = $repo->getCurrencyRatesForPeriod($codes, '-7 days');
                dump($rates);
            } else {
                exit('data is not valid');
            }
//            $this->cacheService->setCache($param, $rates);
            exit('cache is not exist');
        }
    }

    /**
     * @Route("/currencyTable", name="homepage1")
     */
    public function getAction() {
        $matrix = $this->fetchCurrencyPricesService->getCurrencyRate(false);
        return $this->render('currency/index.html.twig', ['matrix' => $matrix]);
    }
}