<?php

/**
 * David Wright Images
 *
 * @author  Elliot Wright <wright.elliot@gmail.com>
 * @since   2013
 * @package DWI
 */

namespace DWI\StaticBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Static Controller
 */
class StaticController extends Controller
{
    public function homeAction()
    {
        return $this->render('DWIStaticBundle:Static:home.html.twig');
    }

    public function aboutAction($name)
    {
        return $this->render('DWIStaticBundle:Default:index.html.twig');
    }
}
