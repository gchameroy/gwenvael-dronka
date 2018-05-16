<?php

namespace AppBundle\Controller\Website;

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
     * @return Response
     */
    public function pricesAction(): Response
    {
        return $this->render('website/static-page/prices.html.twig');
    }

    /**
     * @Route("/sites", name="website_sites")
     * @return Response
     */
    public function sitesAction(): Response
    {
        return $this->render('website/static-page/sites.html.twig');
    }
}
