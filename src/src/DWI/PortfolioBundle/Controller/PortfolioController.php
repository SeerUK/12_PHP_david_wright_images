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
use DWI\PortolioBundle\Entity\GalleryRepository;

/**
 * Portolio Controller
 */
class PortfolioController extends Controller
{
    public function portfolioAction()
    {
        $em        = $this->getDoctrine()->getManager();
        $galleries = $em->getRepository('DWIPortfolioBundle:Gallery')
            ->findAll();

        foreach ($galleries as $gallery) {
            $tags = $gallery->getTags();

            foreach ($tags as $tag) {
                var_dump($tag->getName());
            }

            var_dump($tags);
            exit;
        }

        return $this->render('DWIPortfolioBundle:Portfolio:portfolio.html.twig', array());
    }

    public function galleryAction($id)
    {
        return $this->render('DWIPortfolioBundle:Default:index.html.twig', array('id' => $id));
    }
}
