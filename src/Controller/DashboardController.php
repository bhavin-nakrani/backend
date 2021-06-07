<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends BaseController
{
    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function index()
    {
        return $this->render('dashboard/dashboard.html.twig');
    }
}
