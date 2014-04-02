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
 * Static Controller
 */
class StaticController extends Controller
{
    /**
     * DWI Homepage
     *
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function homeAction()
    {
        $gr = $this->get('dwi_portfolio.gallery_repository');
        $hp = $this->get('dwi_static.static_home_presenter');

        $options = array();
        if ( ! $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            $options['isActive'] = true;
        }

        $hp->setVariable('galleries', $gr->findWithLimit(3, $options));

        return $this->render('DWIStaticBundle:Static:home.html.twig', array(
            'model' => $hp->prepareView(),
        ));
    }

    /**
     * About page
     *
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function aboutAction()
    {
        $pg = $this->get('dwi_static.page_gateway');

        return $this->render('DWIStaticBundle:Static:about.html.twig', array(
            'content' => $pg->findContentByName('about'),
        ));
    }
}
