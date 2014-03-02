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
use DWI\PortfolioBundle\Entity\Gallery;
use DWI\PortfolioBundle\Entity\Tag;

/**
 * Portolio Controller
 */
class PortfolioController extends Controller
{
    /**
     * View all galleries
     *
     * @param  string $page
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function viewAction($page)
    {
        $galleryGateway = $this->get('dwi_portfolio.gallery_gateway');
        $galleryRepo    = $this->get('dwi_portfolio.gallery_repository');
        $tagRepo        = $this->get('dwi_portfolio.tag_repository');
        $presenter      = $this->get('dwi_portfolio.portfolio_view_presenter');

        $options = array();
        if ($this->get('security.context')->isGranted('ROLE_ADMIN')) {
            $viewGateway = $this->get('dwi_portfolio.gallery_view_gateway');
            $presenter->setVariable('views', $viewGateway->findTotal());
        } else {
            $options['isActive'] = true;
        }

        $galleries = $galleryRepo->findByPage($page, $options);

        $presenter
            ->setVariable('galleries', $galleries)
            ->setVariable('galleryCount', $galleryGateway->countTotal($options))
            ->setVariable('page', $page)
            ->setVariable('tags', $tagRepo->findPrimary());

        return $this->render('DWIPortfolioBundle:Portfolio:portfolio.html.twig', array(
            'model' => $presenter->prepareView(),
        ));
    }


    /**
     * Manage all galleries
     *
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function manageAction()
    {
        if ( ! $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }

        $gr = $this->get('dwi_portfolio.gallery_repository');
        $ir = $this->get('dwi_portfolio.image_repository');
        $vg = $this->get('dwi_portfolio.gallery_view_gateway');
        $mp = $this->get('dwi_portfolio.gallery_manage_presenter');

        try {
            $gallery = $gr->findById($id);
        } catch (NoResultException $e) {
            throw $this->createNotFoundException('That gallery doesn\'t exist!');
        }

        $mp->setVariable('gallery', $gallery);
        $mp->setVariable('images', $ir->findByGalleryId($gallery->getId()));
        $mp->setVariable('datedViews', $vg->findDatedByGalleryId($gallery->getId()));
        $mp->setVariable('totalViews', $vg->findByGalleryId($gallery->getId()));

        return $this->render('DWIPortfolioBundle:Portfolio/Admin:gallery-manage.html.twig', array(
            'model' => $mp->prepareView(),
        ));
    }


    /**
     * View galleries with given tag
     *
     * @param  Tag     $tag
     * @param  integer $page
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function viewTagAction(Tag $tag, $page)
    {
        if ( ! $tag) {
            throw $this->createNotFoundException('That tag doesn\'t exist!');
        }

        $galleryGateway = $this->get('dwi_portfolio.gallery_gateway');
        $galleryRepo    = $this->get('dwi_portfolio.gallery_repository');
        $tagRepo        = $this->get('dwi_portfolio.tag_repository');
        $presenter      = $this->get('dwi_portfolio.portfolio_view_tag_presenter');

        $options = array('tagId' => $tag->getId());

        if ($this->get('security.context')->isGranted('ROLE_ADMIN')) {
            $viewGateway = $this->get('dwi_portfolio.gallery_view_gateway');
            $presenter->setVariable('views', $viewGateway->findTotalByTagId($tag->getId()));
        } else {
            $options['isActive'] = true;
        }

        $presenter
            ->setVariable('galleries', $galleryRepo->findBypage($page, $options))
            ->setVariable('galleryCount', $galleryGateway->countTotal($options))
            ->setVariable('page', $page)
            ->setVariable('tag', $tag)
            ->setVariable('tags', $tagRepo->findPrimary());


        return $this->render('DWIPortfolioBundle:Portfolio:portfolio.html.twig', array(
            'model' => $presenter->prepareView(),
        ));
    }
}
