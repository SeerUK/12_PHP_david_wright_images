<?php

namespace DWI\PortfolioBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('DWIPortfolioBundle:Default:index.html.twig', array('name' => $name));
    }
}
