<?php

/**
 * David Wright Images
 *
 * @author  Elliot Wright <wright.elliot@gmail.com>
 * @since   2013
 * @package DWI
 */

namespace DWI\PortfolioBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Portolio Controller
 */
class PortfolioController extends Controller
{
    public function portfolioAction()
    {
        return $this->render('DWIPortfolioBundle:Portfolio:portfolio.html.twig', array());
    }

    public function galleryAction($id)
    {
        return $this->render('DWIPortfolioBundle:Default:index.html.twig', array('id' => $id));
    }
}
