<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DashController extends Controller
{
    /**
     * @Route("/dash", name="dash")
     */
    public function indexAction()
    {
        return $this->render('dash/index.html.twig');
    }
}