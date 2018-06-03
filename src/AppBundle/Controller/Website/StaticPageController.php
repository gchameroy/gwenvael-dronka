<?php

namespace AppBundle\Controller\Website;

use AppBundle\Manager\PriceManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class StaticPageController extends Controller
{
    /**
     * @Route("/", name="website_home")
     * @return Response
     */
    public function homeAction(): Response
    {
        return $this->render('website/static-page/home.html.twig');
    }

    /**
     * @Route("/tarifs", name="website_prices")
     * @param PriceManager $priceManager
     * @return Response
     */
    public function pricesAction(PriceManager $priceManager): Response
    {
        return $this->render('website/static-page/prices.html.twig', [
            'prices' => $priceManager->getList(),
            'offers' => $priceManager->getOffers()
        ]);
    }
}
