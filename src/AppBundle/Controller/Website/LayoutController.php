<?php

namespace AppBundle\Controller\Website;

use AppBundle\Manager\SettingSocialNetworkManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class LayoutController extends Controller
{
    public function socialNetworksAction(SettingSocialNetworkManager $settingSocialNetworkManager): Response
    {
        return $this->render('website/layout/_social-networks.html.twig', [
            'socialNetworks' => $settingSocialNetworkManager->getList(),
        ]);
    }
}
