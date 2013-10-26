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
use DWI\PortolioBundle\Entity\GalleryRepository;

/**
 * Portolio Controller
 */
class PortfolioController extends Controller
{
    public function portfolioAction($page)
    {
        $gr = $this->get('dwi_portfolio.gallery_repository');

        return $this->render('DWIPortfolioBundle:Portfolio:portfolio.html.twig', array(
            "galleries" => $gr->findByPage($page, 2),
        ));
    }

    public function galleryAction($id)
    {
        return $this->render('DWIPortfolioBundle:Default:index.html.twig', array('id' => $id));
    }
}
