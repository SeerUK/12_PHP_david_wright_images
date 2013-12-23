<?php

/**
 * David Wright Images
 *
 * @author  Elliot Wright <wright.elliot@gmail.com>
 * @since   2013
 * @package DWI
 */

namespace DWI\CoreBundle\Gateway\Cache;

use Doctrine\Common\Cache\CacheProvider;
use Doctrine\ORM\EntityManager;

/**
 * Gallery View Gateway
 */
class GatewayCacheFactory
{
    /**
     * @var EntityManager
     */
    private $em;


    /**
     * Constructor
     *
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }


    /**
     * Get result cache
     *
     * @return CacheProvider
     */
    public function getResultCache()
    {
        return $this->em->getConfiguration()->getResultCacheImpl();
    }
}
