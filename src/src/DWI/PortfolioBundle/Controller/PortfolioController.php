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
use Doctrine\ORM\NoResultException;
use DWI\PortfolioBundle\Model\GalleryModel;
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
        $pp = $this->get('dwi_portfolio.portfolio_presenter');
        $vm = $pp->createPortfolioView($gr->findByPage($page, 10));

        return $this->render('DWIPortfolioBundle:Portfolio:portfolio.html.twig', array(
            'model' => $vm
        ));
    }


    /**
     * View Gallery
     *
     * @param  integer $id
     * @return Symfony\Component\HttpFoundation\Response
     *
     * @throws Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function galleryAction($id)
    {
        $gr = $this->get('dwi_portfolio.gallery_repository');
        $gm = new GalleryModel();

        // If the gallery doesn't exist, redirect the user to a 404 page
        try {
            $g  = $gr->findById($id);
        } catch (NoResultException $e) {
            throw $this->createNotFoundException('That gallery doesn\'t exist!');
        }

        return $this->render('DWIPortfolioBundle:Portfolio:gallery.html.twig', array(
            "gallery" => $gm->createGalleryView($g),
        ));
    }
}
