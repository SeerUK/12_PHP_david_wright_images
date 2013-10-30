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
use DWI\PortfolioBundle\Model\PortfolioModel;

/**
 * Portolio Controller
 */
class PortfolioController extends Controller
{
    /**
     * View Portfolio
     *
     * @param  string $page
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function portfolioAction($page)
    {
        $gr = $this->get('dwi_portfolio.gallery_repository');
        $pm = new PortfolioModel();

        var_dump($pm->createPortfolioView($gr->findByPage($page, 10)));

        return $this->render('DWIPortfolioBundle:Portfolio:portfolio.html.twig', array(
            "portfolio" => $pm->createPortfolioView($gr->findByPage($page, 10)),
        ));
    }

    /**
     * View Gallery
     *
     * @param  integer $id
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function galleryAction($id)
    {
        return $this->render('DWIPortfolioBundle:Default:index.html.twig', array('id' => $id));
    }
}
