<?php

/**
 * David Wright Images
 *
 * @author  Elliot Wright <wright.elliot@gmail.com>
 * @since   2013
 * @package DWI
 */

namespace DWI\PortfolioBundle\Mediator;

use Doctrine\ORM\EntityManager;

/**
 * Gallery Mediator
 */
class GalleryMediator
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * Constructor
     *
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function findGalleries()
    {
        return $this->em->getRepository('DWIPortfolioBundle:Gallery')
            ->findAll();
    }
}
