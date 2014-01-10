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
use DWI\PortfolioBundle\Entity\Tag;

/**
 * Tag Repository
 */
class TagRepository extends EntityRepository implements PersistentEntityRepository
{
    /**
     * Find primary tags
     *
     * @return Something
     */
    public function findPrimary()
    {
        $dql = '
            SELECT
                t
            FROM
                DWIPortfolioBundle:Tag AS t
            WHERE
                t.isPrimary = 1
            ORDER BY
                t.name ASC';

        $query = $this->getEntityManager()
            ->createQuery($dql);

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
                ' expected an instance of DWI\PortfolioBundle\Entity\Tag. Received ' .
                gettype($entity)
            );
        }

        $em = $this->getEntityManager();
        $em->persist($entity);
        $em->flush();

        // Clear query cache so that subsequent requests for Tag objects
        // don't return ghosts
        $cd = $em->getConfiguration()->getResultCacheImpl();
        $cd->deleteAll();

        return $this;
    }


    /**
     * Update Gallery
     *
     * @param  Gallery $entity
     * @return GalleryRepository
     */
    public function update($entity)
    {
        if ( ! $this->isEntityType($entity)) {
            throw new \InvalidArgumentException(
                __METHOD__ .
                ' expected an instance of DWI\PortfolioBundle\Entity\Tag. Received ' .
                gettype($entity)
            );
        }

        $em = $this->getEntityManager();
        $em->flush();

        // Clear query cache so that subsequent requests for Tag objects
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
                ' expected an instance of DWI\PortfolioBundle\Entity\Tag. Received ' .
                gettype($entity)
            );
        }

        $em = $this->getEntityManager();
        $em->remove($entity);
        $em->flush();

        // Clear query cache so that subsequent requests for Tag objects
        // don't return ghosts
        $cd = $em->getConfiguration()->getResultCacheImpl();
        $cd->deleteAll();

        return $this;
    }


    /**
     * Is the given entity an instance of Tag?
     *
     * @param  mixed   $entity
     * @return boolean
     */
    public function isEntityType($entity)
    {
        return ($entity instanceof Tag)
            ? true
            : false;
    }
}
