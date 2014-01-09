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
use DWI\PortfolioBundle\Entity\CoverImage;
use DWI\PortfolioBundle\Entity\Gallery;
use DWI\PortfolioBundle\Entity\Image;

/**
 * Gallery Controller
 */
class GalleryController extends Controller
{
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
        $sc = $this->get('security.context');
        $gr = $this->get('dwi_portfolio.gallery_repository');
        $vg = $this->get('dwi_portfolio.gallery_view_gateway');
        $gp = $this->get('dwi_portfolio.gallery_presenter');

        // Try fetch gallery
        try {
            $gallery = $gr->findById($id);
        } catch (NoResultException $e) {
            throw $this->createNotFoundException('That gallery doesn\'t exist!');
        }

        // Record view
        $vg->recordByGalleryId($id);

        // Setup view model
        $gp->setVariable('gallery', $gallery);

        if ($sc->isGranted('ROLE_ADMIN')) {
            $gp->setVariable('views', $vg->findByGalleryId($id));
        }

        return $this->render('DWIPortfolioBundle:Portfolio:gallery.html.twig', array(
            'model' => $gp->prepareView(),
        ));
    }


    /**
     * Create Gallery
     *
     * @return Symfony\Component\HttpFoundation\Response
     *
     * @throws Symfony\Component\HttpKernel\Exception\NotFoundHttpException
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
            $gallery = $form->getData();
            $gallery->setIsActive(false);

            $this->get('dwi_portfolio.gallery_repository')
                ->persist($gallery);

            return $this->redirect($this->generateUrl('dwi_portfolio_gallery', array(
                'id' => $gallery->getId(),
            )));
        }

        return $this->render('DWIPortfolioBundle:Portfolio/Admin:gallery-create.html.twig', array(
            'form' => $form->createView(),
        ));
    }


    /**
     * Delete Gallery
     *
     * @param  Gallery $gallery
     * @return Symfony\Component\HttpFoundation\Response
     *
     * @throws Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @throws Symfony\Component\Security\Core\Exception\AccessDeniedException
     */
    public function editGalleryAction(Gallery $gallery)
    {
        if ( ! $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }

        if ( ! $gallery) {
            throw $this->createNotFoundException('That gallery doesn\'t exist!');
        }

        $request = $this->get('request');
        $factory = $this->get('dwi_portfolio.create_gallery_form_factory');
        $form    = $factory
            ->setGallery($gallery)
            ->prepareForm()
            ->handleRequest($request);

        if ('POST' === $request->getMethod() && $form->isValid()) {
            $gallery = $form->getData();

            $this->get('dwi_portfolio.gallery_repository')
                ->update($gallery);

            return $this->redirect($this->generateUrl('dwi_portfolio_gallery', array(
                'id' => $gallery->getId(),
            )));
        }

        return $this->render('DWIPortfolioBundle:Portfolio/Admin:gallery-edit.html.twig', array(
            'form' => $form->createView(),
            'gallery' => array(
                'id' => $gallery->getId(),
            ),
        ));
    }


    /**
     * Delete Gallery
     *
     * @param  Gallery $gallery
     * @return Symfony\Component\HttpFoundation\Response
     *
     * @throws Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @throws Symfony\Component\Security\Core\Exception\AccessDeniedException
     */
    public function deleteGalleryAction(Gallery $gallery)
    {
        if ( ! $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }

        if ( ! $gallery) {
            throw $this->createNotFoundException('That gallery doesn\'t exist!');
        }

        $request = $this->get('request');

        // If we've viewed and posted our response
        if ('POST' === $request->getMethod()) {
            if ($request->request->get('doDelete')) {
                $this->get('dwi_portfolio.gallery_repository')
                    ->remove($gallery);

                return $this->redirect($this->generateUrl('dwi_portfolio_homepage'));
            }

            // Redirect user to the gallery
            return $this->redirect($this->generateUrl('dwi_portfolio_gallery', array(
                'id' => $gallery->getId(),
            )));
        }

        return $this->render('DWIPortfolioBundle:Portfolio/Admin:gallery-delete.html.twig', array(
            'gallery' => $gallery,
        ));
    }


    /**
     * Set Gallery Cover Image
     *
     * @param Gallery $gallery
     * @param integer $imageId
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function setCoverAction(Gallery $gallery, $imageId)
    {
        if ( ! $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }

        if ( ! $gallery) {
            throw $this->createNotFoundException('That gallery doesn\'t exist!');
        }

        try {
            $image = $this->get('dwi_portfolio.image_repository')
                ->findOneById($imageId);
        } catch (NoResultException $e) {
            throw $this->createNotFoundException('That image doesn\'t exist!');
        }

        $request   = $this->get('request');
        $presenter = $this->get('dwi_portfolio.gallery_set_cover_presenter')
            ->setVariable('gallery', $gallery)
            ->setVariable('image', $image);

        if ('POST' === $request->getMethod()) {
            if ($request->request->get('doSetCover')) {
                $ci = new CoverImage();
                $ci->setGallery($gallery);
                $ci->setImage($image);

                $gallery->setCoverImage($ci);

                $this->get('dwi_portfolio.gallery_repository')
                    ->update($gallery);
            }


            return $this->redirect($this->generateUrl('dwi_portfolio_gallery', array(
                'id' => $gallery->getId(),
            )));
        }

        return $this->render('DWIPortfolioBundle:Portfolio/Admin:gallery-set-cover.html.twig', array(
            'model' => $presenter->prepareView(),
        ));
    }


    /**
     * Publish Gallery
     *
     * @param  Gallery $gallery
     * @return Symfony\Component\HttpFoundation\Response
     *
     * @throws Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @throws Symfony\Component\Security\Core\Exception\AccessDeniedException
     */
    public function publishGalleryAction(Gallery $gallery)
    {
        if ( ! $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }

        if ( ! $gallery) {
            throw $this->createNotFoundException('That gallery doesn\'t exist!');
        }

        $request = $this->get('request');

        // If we've viewed and posted our response
        if ('POST' === $request->getMethod()) {
            // Unpublish
            if ($request->request->get('doUnpublish')) {
                $gallery->setIsActive(false);

                $this->get('dwi_portfolio.gallery_repository')
                    ->persist($gallery);
            }

            // Publish
            if ($request->request->get('doPublish')) {
                $gallery->setIsActive(true);

                $this->get('dwi_portfolio.gallery_repository')
                    ->persist($gallery);
            }

            // Redirect user to the gallery
            return $this->redirect($this->generateUrl('dwi_portfolio_gallery', array(
                'id' => $gallery->getId(),
            )));
        }

        return $this->render('DWIPortfolioBundle:Portfolio/Admin:gallery-publish.html.twig', array(
            'gallery' => $gallery,
        ));
    }
}
