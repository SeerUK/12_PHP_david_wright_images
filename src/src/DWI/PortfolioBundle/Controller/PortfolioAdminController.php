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
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Doctrine\ORM\NoResultException;
use DWI\CoreBundle\HttpFoundation\RestJsonResponse;
use DWI\PortfolioBundle\Entity\CoverImage;
use DWI\PortfolioBundle\Entity\Gallery;
use DWI\PortfolioBundle\Entity\Image;

/**
 * Portfolio Admin Controller
 */
class PortfolioAdminController extends Controller
{
    /**
     * Manage Gallery
     *
     * @param  Gallery $gallery
     * @return Symfony\Component\HttpFoundation\Response
     *
     * @throws Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @throws Symfony\Component\Security\Core\Exception\AccessDeniedException
     */
    public function viewAction($page)
    {
        if ( ! $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }

        $gg = $this->get('dwi_portfolio.gallery_gateway');
        $gr = $this->get('dwi_portfolio.gallery_repository');
        $vg = $this->get('dwi_portfolio.gallery_view_gateway');
        $pp = $this->get('dwi_portfolio.portfolio_manage_presenter');

        $galleries = $gr->findByPage($page);

        $pp->setVariable('page',         $page);
        $pp->setVariable('galleries',    $galleries);
        $pp->setVariable('galleryCount', $gg->countTotal());
        $pp->setVariable('datedViews',   $vg->findDated());
        $pp->setVariable('totalViews',   $vg->findTotal());

        return $this->render('DWIPortfolioBundle:Portfolio/Admin:portfolio-manage.html.twig', array(
            'model' => $pp->prepareView(),
        ));
    }
}
