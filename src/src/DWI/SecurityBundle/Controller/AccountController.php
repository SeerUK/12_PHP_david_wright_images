<?php

/**
 * David Wright Images
 *
 * @author  Elliot Wright <wright.elliot@gmail.com>
 * @since   2013
 * @package DWI
 */

namespace DWI\SecurityBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;

/**
 * Account Controller
 */
class AccountController extends Controller
{
    public function loginAction()
    {
        $request = $this->getRequest();
        $session = $request->getSession();

        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }

        return $this->render('DWISecurityBundle:Login:index.html.twig', array(
            'error'         => $error,
            'last_username' => $session->get(SecurityContext::LAST_USERNAME),
            'pageTitle'     => 'Login',
            'referer'       => $request->headers->get('referer'),
        ));
    }
}
