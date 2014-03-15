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
    public function homeAction()
    {
        $gr = $this->get('dwi_portfolio.gallery_repository');
        $hp = $this->get('dwi_static.static_home_presenter');

        $hp->setVariable('galleries', $gr->findWithLimit(3));

        return $this->render('DWIStaticBundle:Static:home.html.twig', array(
            'model' => $hp->prepareView(),
        ));
    }

    public function aboutAction()
    {
        $pg = $this->get('dwi_static.page_gateway');

        return $this->render('DWIStaticBundle:Static:about.html.twig', array(
            'content' => $pg->findContentByName('about'),
        ));
    }
}
