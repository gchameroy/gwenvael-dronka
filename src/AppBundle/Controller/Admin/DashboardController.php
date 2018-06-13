<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Manager\SettingCounterManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class DashboardController extends Controller
{
    /**
     * @Route("/", name="admin_dashboard")
     * @return Response
     */
    public function viewAction(): Response
    {
        return $this->render('admin/dashboard/view.html.twig');
    }
}
