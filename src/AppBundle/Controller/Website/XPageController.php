<?php

namespace AppBundle\Controller\Website;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class XPageController extends Controller
{
    /**
     * @Route("/{slug}", name="website_page")
     * @return Response
     */
    public function pageAction(): Response
    {
        // todo
        throw new \Exception('Not implemented');
    }
}
