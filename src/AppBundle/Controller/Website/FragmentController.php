<?php

namespace AppBundle\Controller\Website;

use AppBundle\Manager\PageManager;
use AppBundle\Manager\PriceManager;
use AppBundle\Manager\SettingCounterManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class FragmentController extends Controller
{
    public function lessonsAction(PriceManager $priceManager): Response
    {
        return $this->render('website/fragment/_lessons.html.twig', [
            'prices' => $priceManager->getList(),
        ]);
    }

    public function _countersAction(SettingCounterManager $settingCounterManager)
    {
        return $this->render('website/fragment/_counters.html.twig', [
            'settingCounters' => $settingCounterManager->getList(),
        ]);
    }
}
