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
use DWI\PortfolioBundle\Entity\Tag;

/**
 * Tag Admin Controller
 */
class TagAdminController extends Controller
{
    /**
     * Create Tag
     *
     * @return Symfony\Component\HttpFoundation\Response
     *
     * @throws Symfony\Component\Security\Core\Exception\AccessDeniedException
     */
    public function createAction()
    {
        if ( ! $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }

        $request = $this->get('request');
        $form    = $this->get('dwi_portfolio.create_tag_form')
            ->handleRequest($request);

        if ('POST' === $request->getMethod() && $form->isValid()) {
            $this->get('dwi_portfolio.tag_repository')
                ->persist($form->getData());

            return $this->redirect($this->generateUrl('dwi_portfolio_manage_tags'));
        }

        return $this->render('DWIPortfolioBundle:Portfolio/Admin:tag-create.html.twig', array(
            'form' => $form->createView(),
        ));
    }


    /**
     * Edit Tag
     *
     * @param  Tag $tag
     * @return Symfony\Component\HttpFoundation\Response
     *
     * @throws Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @throws Symfony\Component\Security\Core\Exception\AccessDeniedException
     */
    public function editAction(Tag $tag)
    {
        if ( ! $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }

        if ( ! $tag) {
            throw $this->createNotFoundException('That tag doesn\'t exist!');
        }

        $request = $this->get('request');
        $factory = $this->get('dwi_portfolio.create_tag_form_factory');
        $form    = $factory
            ->setTag($tag)
            ->prepareForm()
            ->handleRequest($request);

        if ('POST' === $request->getMethod() && $form->isValid()) {
            $tag = $form->getData();

            $this->get('dwi_portfolio.tag_repository')
                ->update($tag);

            return $this->redirect($this->generateUrl('dwi_portfolio_manage_tags'));
        }

        return $this->render('DWIPortfolioBundle:Portfolio/Admin:tag-edit.html.twig', array(
            'form' => $form->createView(),
            'tag'  => $tag,
        ));
    }


    /**
     * Delete Tag
     *
     * @param  Tag $tag
     * @return Symfony\Component\HttpFoundation\Response
     *
     * @throws Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @throws Symfony\Component\Security\Core\Exception\AccessDeniedException
     */
    public function deleteAction(Tag $tag)
    {
        if ( ! $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }

        if ( ! $tag) {
            throw $this->createNotFoundException('That tag doesn\'t exist!');
        }

        $request = $this->get('request');

        if ('POST' === $request->getMethod()) {
            if ($request->request->get('doDelete')) {
                $this->get('dwi_portfolio.tag_repository')
                    ->remove($tag);
            }

            return $this->redirect($this->generateUrl('dwi_portfolio_manage_tags'));
        }

        return $this->render('DWIPortfolioBundle:Portfolio/Admin:tag-delete.html.twig', array(
            'tag' => $tag,
        ));
    }
}
