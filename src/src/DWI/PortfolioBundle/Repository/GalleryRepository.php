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
use DWI\CoreBundle\Repository\PersistentEntityRepository;
use DWI\PortfolioBundle\Entity\Gallery;

/**
 * Gallery Repository
 */
class GalleryRepository extends EntityRepository implements PersistentEntityRepository
{
    /**
     * Find galleryes by id, also returns gallery images
     *
     * @param  integer $id
     * @return DWI\PortfolioBundle\Entity\Gallery
     */
    public function findById($id)
    {
        $dql = '
            SELECT
                g,
                gci,
                gi,
                gv
            FROM
                DWIPortfolioBundle:Gallery AS g
            LEFT JOIN
                g.coverImage AS gci
            LEFT JOIN
                g.images AS gi
            LEFT JOIN
                g.views AS gv
            WHERE
                g.id = :id';

        $query = $this->getEntityManager()->createQuery($dql)
            ->setParameter('id', $id);

        return $query->useResultCache(true)
            ->getSingleResult();
    }


    /**
     * Find galleries by page, returns gallery cover images and tags too
     *
     * @param  integer $page
     * @param  integer $limit
     * @return array
     */
    public function findByPage($page, $limit)
    {
        $dql    = '
            SELECT
                g,
                gci,
                gcii,
                t,
                gv
            FROM
                DWIPortfolioBundle:Gallery AS g
            LEFT JOIN
                g.coverImage AS gci
            LEFT JOIN
                gci.image AS gcii
            LEFT JOIN
                g.tags AS t
            LEFT JOIN
                g.views AS gv';

        $offset = $this->getPageFirstResult($page, $limit);
        $query  = $this->getEntityManager()->createQuery($dql)
            ->setFirstResult($offset)
            ->setMaxResults($limit);

        return $query->useResultCache(true)
            ->getResult();
    }


    /**
     * Persist Gallery
     *
     * @param  Gallery $entity
     * @return GalleryRepository
     */
    public function persist($entity)
    {
        if ( ! $this->isEntityType($entity)) {
            throw new \InvalidArgumentException(
                __METHOD__ .
                ' expected an instance of DWI\PortfolioBundle\Entity\Gallery. Received ' .
                gettype($entity)
            );
        }

        $em = $this->getEntityManager();
        $em->persist($entity);
        $em->flush();

        // Clear query cache so that subsequent requests for Gallery objects
        // don't return ghosts
        $cd = $em->getConfiguration()->getResultCacheImpl();
        $cd->deleteAll();

        return $this;
    }


    /**
     * Remove Gallery
     *
     * @param  Gallery $entity
     * @return GalleryRepository
     */
    public function remove($entity)
    {
        if ( ! $this->isEntityType($entity)) {
            throw new \InvalidArgumentException(
                __METHOD__ .
                ' expected an instance of DWI\PortfolioBundle\Entity\Gallery. Received ' .
                gettype($entity)
            );
        }

        $em = $this->getEntityManager();
        $em->remove($entity);
        $em->flush();

        // Clear query cache so that subsequent requests for Gallery objects
        // don't return ghosts
        $cd = $em->getConfiguration()->getResultCacheImpl();
        $cd->deleteAll();

        return $this;
    }


    /**
     * Is the given entity an instance of Gallery?
     *
     * @param  mixed   $entity
     * @return boolean
     */
    public function isEntityType($entity)
    {
        return ($entity instanceof Gallery)
            ? true
            : false;
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
