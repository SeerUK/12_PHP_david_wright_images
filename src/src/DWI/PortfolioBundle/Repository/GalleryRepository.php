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
     * Find galleries by page
     *
     * @param  integer $page
     * @param  integer $limit
     * @return array
     */
    public function findByPage($page, $limit)
    {
        $dql    = 'SELECT g, gi, t FROM DWIPortfolioBundle:Gallery AS g LEFT JOIN g.images AS gi LEFT JOIN g.tags AS t';
        $offset = $this->getPageFirstResult($page, $limit);

        $query = $this->getEntityManager()
            ->createQuery($dql)
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
