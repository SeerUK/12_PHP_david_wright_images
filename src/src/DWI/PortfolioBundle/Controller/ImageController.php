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
 * Image Controller
 */
class ImageController extends Controller
{
    /**
     * Upload Images
     *
     * @param  Gallery $gallery
     * @return Symfony\Component\HttpFoundation\Response
     *
     * @throws Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @throws Symfony\Component\Security\Core\Exception\AccessDeniedException
     */
    public function uploadImagesAction(Gallery $gallery)
    {
        if ( ! $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }

        if ( ! $gallery) {
            throw $this->createNotFoundException('That gallery doesn\'t exist!');
        }

        $request = $this->get('request');
        $form    = $this->get('dwi_portfolio.upload_image_form')
            ->handleRequest($request);

        if ('POST' === $request->getMethod() && $form->isValid()) {
            $image = $form->getData();
            $image->setGallery($gallery);

            $this->get('dwi_portfolio.image_repository')
                ->persist($image);

            return $this->redirect($this->generateUrl('dwi_portfolio_gallery', array(
                'id' => $gallery->getId(),
            )));
        }

        $uip = $this->get('dwi_portfolio.upload_image_presenter')
            ->setVariable('form', $form)
            ->setVariable('gallery', $gallery);

        return $this->render('DWIPortfolioBundle:Portfolio/Admin:image-upload.html.twig', array(
            'model' => $uip->prepareView(),
        ));
    }
}
