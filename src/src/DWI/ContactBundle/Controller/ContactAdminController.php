<?php

/**
 * David Wright Images
 *
 * @author  Elliot Wright <wright.elliot@gmail.com>
 * @since   2013
 * @package DWI
 */

namespace DWI\ContactBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Validator\Constraints\Email as EmailConstraint;

/**
 * Contact Controller
 */
class ContactAdminController extends Controller
{
    /**
     * Update settings
     *
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function settingsAction()
    {
        $errors = null;
        $req    = $this->get('request');
        $cvg    = $this->get('dwi_contact.con_var_gateway');
        $form   = $this->createFormBuilder()
            ->add('email', 'email', array(
                'attr' => array(
                    'placeholder' => 'Enter new recipient'
                )
            ))
            ->add('submit', 'submit')
            ->getForm();

        $form->handleRequest($req);

        if ('POST' === $req->getMethod() && $form->isValid()) {
            $data = $form->getData();

            $ec = new EmailConstraint();
            $errors = $this->get('validator')
                ->validateValue($data['email'], $ec);

            if ( ! $errors->count()) {
                $cvg->updateByName('contact.recipient', $data['email']);

                return $this->redirect($this->generateUrl('dwi_contact_admin_settings'));
            }
        }

        return $this->render('DWIContactBundle:Contact:admin/settings.html.twig', array(
            'recipient' => $cvg->findByName('contact.recipient'),
            'form'      => $form->createView(),
            'errors'    => $errors,
        ));
    }
}
