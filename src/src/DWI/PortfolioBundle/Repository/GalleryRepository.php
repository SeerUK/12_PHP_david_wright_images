<?php

/**
 * David Wright Images
 *
 * @author  Elliot Wright <wright.elliot@gmail.com>
 * @since   2013
 * @package DWI
 */

namespace DWI\PortfolioBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

/**
 * Gallery Repository
 */
class GalleryRepository extends EntityRepository
{
    /**
     * Find galleries by page, returns gallery images and tags too
     *
     * @param  integer $page
     * @param  integer $limit
     * @return array
     */
    public function findByPage($page, $limit)
    {
        $dql    = 'SELECT g, gci, gcii, t FROM DWIPortfolioBundle:Gallery AS g LEFT JOIN g.coverImage AS gci LEFT JOIN gci.image AS gcii LEFT JOIN g.tags AS t';
        $offset = $this->getPageFirstResult($page, $limit);

        $query = $this->getEntityManager()->createQuery($dql)
            ->setFirstResult($offset)
            ->setMaxResults($limit);

        return $query->useResultCache(true)
            ->getResult();
    }

    /**
     * Get first result number (offset) for page
     *
     * @param  integer $page
     * @param  integer $limit
     * @return integer
     */
    private function getPageFirstResult($page, $limit)
    {
        return (($page - 1) * $limit);
    }
}
