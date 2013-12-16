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
            'model' => $vm,
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


    /**
     * Create Gallery
     *
     * @return Symfony\Component\HttpFoundation\Response
     *
     * @throws Symfony\Component\Security\Core\Exception\AccessDeniedException
     */
    public function createGalleryAction()
    {
        if ( ! $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }

        $request = $this->get('request');
        $form    = $this->get('dwi_portfolio.create_gallery_form')
            ->handleRequest($request);

        if ('POST' === $request->getMethod() && $form->isValid()) {
            $this->get('dwi_portfolio.gallery_repository')
                ->persist($form->getData());

            return $this->redirect($this->generateUrl('dwi_portfolio_gallery', array(
                'id' => $gallery->getId(),
            )));
        }

        return $this->render('DWIPortfolioBundle:Portfolio:createGallery.html.twig', array(
            'form' => $form->createView(),
        ));
    }


    /**
     * Remove Gallery
     *
     * @param  integer $id
     * @return Symfony\Component\HttpFoundation\Response
     *
     * @throws Symfony\Component\Security\Core\Exception\AccessDeniedException
     */
    public function removeGalleryAction(Gallery $gallery)
    {
        if ( ! $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }

        if ( ! $gallery) {
            throw $this->createNotFoundException('That gallery doesn\'t exist!');
        }

        $this->get('dwi_portfolio.gallery_repository')
            ->remove($gallery);

        return $this->redirect($this->generateUrl('dwi_portfolio_homepage'));
    }
}
