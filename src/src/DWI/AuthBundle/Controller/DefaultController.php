<?php

namespace DWI\AuthBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('DWIAuthBundle:Default:index.html.twig', array('name' => $name));
    }
}
