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
use DWI\PortfolioBundle\Entity\Gallery;
use DWI\PortfolioBundle\Form\Type\GalleryType;

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
     */
    public function createGalleryAction()
    {
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }

        // Make CreateGalleryType, pass a new GalleryType into it, use
        // the registration docs on symfony to try figure it out

        $gallery = new Gallery();
        $request = $this->getRequest();
        $form = $this->createForm(new GalleryType(), $gallery, array(
            'action' => $this->generateUrl('dwi_portfolio_create_gallery'),
        ));

        var_dump($form->isValid());
        var_dump($gallery);
        var_dump($form->getData());

        if ('POST' === $request->getMethod() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($gallery);
            $em->flush();

            return $this->redirect($this->generateUrl('dwi_portfolio_homepage'));
        }

        return $this->render('DWIPortfolioBundle:Portfolio:createGallery.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
