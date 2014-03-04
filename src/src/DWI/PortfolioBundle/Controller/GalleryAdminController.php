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
 * Gallery Controller
 */
class GalleryAdminController extends Controller
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
    public function viewAction($id)
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
     * Sort Gallery Images
     *
     * @param  integer $id
     * @param  array  $order
     * @return Symfony\Component\HttpFoundation\Response
     *
     * @throws Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @throws Symfony\Component\Security\Core\Exception\AccessDeniedException
     */
    public function sortAction($id)
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
        $ig = $this->get('dwi_portfolio.image_gateway');

        try {
            $gallery = $gr->findById($id);
        } catch (NoResultException $e) {
            throw $this->createNotFoundException('That gallery doesn\'t exist!');
        }

        $response->setData($request->get('order'));

        return $response;
    }
}
