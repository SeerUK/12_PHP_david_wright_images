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
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Doctrine\ORM\NoResultException;
use DWI\CoreBundle\HttpFoundation\RestJsonResponse;
use DWI\PortfolioBundle\Entity\Gallery;
use DWI\PortfolioBundle\Entity\Image;

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
    public function uploadImagesFormAction(Gallery $gallery)
    {
        if ( ! $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }

        if ( ! $gallery) {
            throw $this->createNotFoundException('That gallery doesn\'t exist!');
        }

        $request = $this->get('request');
        $form    = $this->get('dwi_portfolio.upload_image_form');

        $uip = $this->get('dwi_portfolio.image_upload_presenter')
            ->setVariable('form', $form)
            ->setVariable('gallery', $gallery);

        return $this->render('DWIPortfolioBundle:Portfolio/Admin:image-upload.html.twig', array(
            'model' => $uip->prepareView(),
        ));
    }


    /**
     * Swap display order of images around
     *
     * @param  integer $fromPosition
     * @param  integer $toPosition
     * @return [type]               [description]
     */
    public function swapDisplayOrderAction($id, $from, $to)
    {
        if ( ! $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }

        $gr = $this->get('dwi_portfolio.gallery_repository');
        $ir = $this->get('dwi_portfolio.image_repository');

        // Try fetch gallery
        try {
            $gallery = $gr->findById($id);
        } catch (NoResultException $e) {
            throw $this->createNotFoundException('That gallery doesn\'t exist!');
        }

        $ir->swapImageDisplayOrderByGalleryId($gallery->getId(), $from, $to);

        return $this->redirect($this->generateUrl('dwi_portfolio_manage_gallery', array(
            'id' => $gallery->getId(),
        )));
    }


    /**
     * Upload Image
     *
     * @param  integer $id
     * @return Symfony\Component\HttpFoundation\JsonResponse
     */
    public function uploadImageAction($id)
    {
        $request  = $this->get('request');
        $response = new RestJsonResponse();

        if ( ! $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            return $response->addError(RestJsonResponse::GENERIC_BAD_AUTH)
                ->setStatusCode(403);
        } elseif ('POST' !== $request->getMethod()) {
            return $response->addError(RestJsonResponse::BAD_REQUEST_METHOD)
                ->setStatusCode(400);
        }

        $gr = $this->get('dwi_portfolio.gallery_repository');

        // Try fetch gallery
        try {
            $gallery = $gr->findById($id);
        } catch (NoResultException $e) {
            return $response->addError(RestJsonResponse::ENTITY_NOT_FOUND)
                ->setStatusCode(404);
        }

        $form = $this->get('dwi_portfolio.upload_image_form')
            ->handleRequest($request);

        if ($form->isValid()) {
            $image = $form->getData();
            $image->setGallery($gallery);

            try {
                $this->get('dwi_portfolio.image_repository')
                    ->persist($image);

                $response->setData(array(
                    'id' => $image->getId(),
                ));
            } catch (FileException $e) {
                $response->addError($e->getMessage())
                    ->setStatusCode(500);
            }
        } else {
            if (count($form->getErrors())) {
                foreach ($form->getErrors() as $error) {
                    $response->addError($error->getMessage());
                }
            } else {
                $response->addError(RestJsonResponse::GENERIC_BAD_REQUEST);
            }

            $response->setStatusCode(400);
        }

        return $response;
    }


    /**
     * Edit Image Description
     *
     * @param  integer $galleryId
     * @param  Image   $image
     * @return Symfony\Component\HttpFoundation\Response
     *
     * @throws Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @throws Symfony\Component\Security\Core\Exception\AccessDeniedException
     */
    public function editDescriptionAction($galleryId, Image $image)
    {
        if ( ! $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }

        if ( ! $image) {
            throw $this->createNotFoundException('That image doesn\'t exist!');
        }

        $request   = $this->get('request');
        $presenter = $this->get('dwi_portfolio.image_edit_description_presenter')
            ->setVariable('image', $image);

        // If we've viewed and posted our response
        if ('POST' === $request->getMethod()) {
            if ($request->request->get('doEdit')) {
                $image->setDescription($request->request->get('desc'));

                $this->get('dwi_portfolio.image_repository')
                    ->update($image);
            }

            // Redirect user to the gallery
            return $this->redirect($this->generateUrl('dwi_portfolio_manage_gallery', array(
                'id' => $galleryId,
            )));
        }

        return $this->render('DWIPortfolioBundle:Portfolio/Admin:image-edit-description.html.twig', array(
            'model' => $presenter->prepareView(),
        ));
    }


    /**
     * Delete Image
     *
     * @param  integer $galleryId
     * @param  Image   $image
     * @return Symfony\Component\HttpFoundation\Response
     *
     * @throws Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @throws Symfony\Component\Security\Core\Exception\AccessDeniedException
     */
    public function deleteImageAction($galleryId, Image $image)
    {
        if ( ! $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }

        if ( ! $image) {
            throw $this->createNotFoundException('That image doesn\'t exist!');
        }

        $request   = $this->get('request');
        $presenter = $this->get('dwi_portfolio.image_delete_presenter')
            ->setVariable('image', $image);

        // If we've viewed and posted our response
        if ('POST' === $request->getMethod()) {
            if ($request->request->get('doDelete')) {
                $this->get('dwi_portfolio.image_repository')
                    ->remove($image);
            }

            // Redirect user to the gallery
            return $this->redirect($this->generateUrl('dwi_portfolio_manage_gallery', array(
                'id' => $galleryId,
            )));
        }

        return $this->render('DWIPortfolioBundle:Portfolio/Admin:image-delete.html.twig', array(
            'model' => $presenter->prepareView(),
        ));
    }
}
