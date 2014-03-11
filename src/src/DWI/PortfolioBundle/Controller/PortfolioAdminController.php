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
     * Manage Galleries
     *
     * @param  integer $page
     * @return Symfony\Component\HttpFoundation\Response
     *
     * @throws Symfony\Component\Security\Core\Exception\AccessDeniedException
     */
    public function galleriesAction($page)
    {
        if ( ! $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }

        $gg = $this->get('dwi_portfolio.gallery_gateway');
        $gr = $this->get('dwi_portfolio.gallery_repository');
        $vg = $this->get('dwi_portfolio.gallery_view_gateway');
        $gp = $this->get('dwi_portfolio.galleries_manage_presenter');

        $gp->setVariable('page',         $page);
        $gp->setVariable('galleries',    $gr->findByPage($page));
        $gp->setVariable('galleryCount', $gg->countTotal());
        $gp->setVariable('datedViews',   $vg->findDated());
        $gp->setVariable('totalViews',   $vg->findTotal());

        return $this->render('DWIPortfolioBundle:Portfolio/Admin:galleries-manage.html.twig', array(
            'model' => $gp->prepareView(),
        ));
    }


    /**
     * Manage Tags
     *
     * @return Symfony\Component\HttpFoundation\Response
     *
     * @throws Symfony\Component\Security\Core\Exception\AccessDeniedException
     */
    public function tagsAction()
    {
        if ( ! $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }

        $tr = $this->get('dwi_portfolio.tag_repository');
        $tp = $this->get('dwi_portfolio.tags_manage_presenter');

        $tp->setVariable('tags', $tr->findAll());

        return $this->render('DWIPortfolioBundle:Portfolio/Admin:tags-manage.html.twig', array(
            'model' => $tp->prepareView(),
        ));
    }
}
