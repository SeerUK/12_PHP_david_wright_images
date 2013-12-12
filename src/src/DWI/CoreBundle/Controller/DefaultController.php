<?php

namespace DWI\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('DWICoreBundle:Default:index.html.twig', array('name' => $name));
    }
}
