<?php

namespace AppBundle\Controller\Website;

use AppBundle\Manager\MenuManager;
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

    public function menuAction(MenuManager $menuManager): Response
    {
        return $this->render('website/layout/_header.html.twig', [
            'menus' => $menuManager->getList(),
        ]);
    }
}
