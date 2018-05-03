<?php

namespace AppBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class HomeController extends Controller
{
    /**
     * @Route("/admin", name="dashboard")
     */
    public function listAction()
    {
        return $this->render('admin/dashboard/dashboard.html.twig');
    }
}
