<?php

/**
 * David Wright Images
 *
 * @author  Elliot Wright <wright.elliot@gmail.com>
 * @since   2013
 * @package DWI
 */

namespace DWI\StaticBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Static Admin Controller
 */
class StaticAdminController extends Controller
{
    /**
     * About page settings
     *
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function aboutAction()
    {
        $errors  = null;
        $req     = $this->get('request');

        $pg      = $this->get('dwi_static.page_gateway');
        $content = $pg->findContentByName('about');

        $form   = $this->createFormBuilder()
            ->add('content', 'textarea', array(
                'attr' => array(
                    'placeholder' => 'About yourself...',
                ),
                'data' => $content,
            ))
            ->add('submit', 'submit')
            ->getForm();

        $form->handleRequest($req);

        if ('POST' === $req->getMethod() && $form->isValid()) {
            $data = $form->getData();
            $pg->updateContentByName('about', $data['content']);

            return $this->redirect($this->generateUrl('dwi_static_about_settings'));
        }

        return $this->render('DWIStaticBundle:Static:admin/settings.html.twig', array(
            'form'    => $form->createView(),
            'errors'  => $errors,
        ));
    }
}
