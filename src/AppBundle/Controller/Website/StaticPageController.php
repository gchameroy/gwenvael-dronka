<?php

namespace AppBundle\Controller\Website;

use AppBundle\Entity\PageStatic;
use AppBundle\Manager\PriceManager;
use AppBundle\Manager\PageStaticManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class StaticPageController extends Controller
{
    /** @var PageStaticManager */
    private $pageStaticManager;

    public function __construct(PageStaticManager $pageStaticManager)
    {
        $this->pageStaticManager = $pageStaticManager;
    }

    /**
     * @Route("/", name="website_home")
     * @return Response
     */
    public function homeAction(): Response
    {
        /** @var $pageStatic PageStatic */
        $pageStatic = $this->pageStaticManager->get(PageStatic::PAGE_HOME);

        return $this->render('website/static-page/home.html.twig', [
            'pageStatic' => $pageStatic,
        ]);
    }

    /**
     * @Route("/tarifs", name="website_prices")
     * @param PriceManager $priceManager
     * @return Response
     */
    public function pricesAction(PriceManager $priceManager): Response
    {
        /** @var $pageStatic PageStatic */
        $pageStatic = $this->pageStaticManager->get(PageStatic::PAGE_PRICE);

        return $this->render('website/static-page/prices.html.twig', [
            'prices' => $priceManager->getList(),
            'pageStatic' => $pageStatic,
        ]);
    }
}
