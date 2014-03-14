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

/**
 * Contact Controller
 */
class ContactController extends Controller
{
    /**
     * Send email form
     *
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function viewAction()
    {
        return $this->render('DWIContactBundle:Contact:view.html.twig');
    }


    /**
     * Sends email
     *
     * @return Symfony\Component\HttpFoundation\Response
     *
     * @throws Doctrine\ORM\NoResultException
     */
    public function sendAction()
    {
        $req = $this->get('request');
        $cvg = $this->get('dwi_contact.con_var_gateway');

        $message = \Swift_Message::newInstance()
            ->setSubject('[David Wright Images] Contact from ' . $req->request->get('name'))
            ->setFrom($this->container->parameters['mailer_user'])
            ->setTo($cvg->findByName('contact.recipient'))
            ->setBody(
                $this->renderView(
                    'DWIContactBundle:Contact:email/contact.txt.twig', array(
                        'name'    => $req->request->get('name'),
                        'email'   => $req->request->get('email'),
                        'message' => $req->request->get('message'),
                    )
                )
            );

        if (filter_var($req->request->get('email'), FILTER_VALIDATE_EMAIL)) {
            $message->setReplyTo($req->request->get('email'));
        }

        $this->get('mailer')->send($message);

        return $this->redirect($this->generateUrl('dwi_contact_sent'));
    }


    /**
     * Confirm result of sending message
     *
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function sentAction()
    {
        return $this->render('DWIContactBundle:Contact:confirm.html.twig');
    }
}
