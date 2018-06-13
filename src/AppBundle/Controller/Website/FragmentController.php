<?php

namespace AppBundle\Controller\Website;

use AppBundle\Manager\PageManager;
use AppBundle\Manager\SettingCounterManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class FragmentController extends Controller
{
    public function lessonsAction(PageManager $pageManager): Response
    {
        return $this->render('website/fragment/_lessons.html.twig', [
            'page' => $pageManager->getLesson(),
        ]);
    }

    public function _countersAction(SettingCounterManager $settingCounterManager)
    {
        return $this->render('website/fragment/_counters.html.twig', [
            'settingCounters' => $settingCounterManager->getList(),
        ]);
    }
}
