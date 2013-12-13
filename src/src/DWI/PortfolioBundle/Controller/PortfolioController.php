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

        $vm = $pp->setVariable('galleries', $gr->findByPage($page, 10))
            ->prepareView();

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
        $gp = $this->get('dwi_portfolio.gallery_presenter');

        // If the gallery doesn't exist, redirect the user to a 404 page
        try {
            $vm = $gp->setVariable('gallery', $gr->findById($id))
                ->prepareView();
        } catch (NoResultException $e) {
            throw $this->createNotFoundException('That gallery doesn\'t exist!');
        }

        return $this->render('DWIPortfolioBundle:Portfolio:gallery.html.twig', array(
            'model' => $vm,
        ));
    }
}
