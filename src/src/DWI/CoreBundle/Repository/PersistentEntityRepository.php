<?php

/**
 * David Wright Images
 *
 * @author  Elliot Wright <wright.elliot@gmail.com>
 * @since   2013
 * @package DWI
 */

namespace DWI\CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;
use DWI\PortfolioBundle\Entity\Gallery;

/**
 * Persistent Entity Repository
 */
interface PersistentEntityRepository
{
    public function persist($entity);
    public function remove($entity);
    public function isEntityType($entity);
}
