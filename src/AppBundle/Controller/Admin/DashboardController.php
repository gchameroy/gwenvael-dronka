<?php

namespace AppBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DashboardController extends Controller
{
    /**
     * @Route("/", name="admin_dashboard")
     */
    public function viewAction()
    {
        return $this->render('admin/dashboard/view.html.twig');
    }
}
