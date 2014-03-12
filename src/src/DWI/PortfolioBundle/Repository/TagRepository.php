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
use DWI\PortfolioBundle\Entity\Tag;

/**
 * Tag Repository
 */
class TagRepository extends EntityRepository implements PersistentEntityRepository
{
    /**
     * Find all tags
     *
     * @return object
     */
    public function findAll()
    {
        $query = $this->createQueryBuilder('t')
            ->orderBy('t.name', 'ASC')
            ->getQuery();

        return $query->useResultCache(true)
            ->getResult();
    }


    /**
     * Find tags by gallery id
     *
     * @param  integer $id
     * @return object
     */
    public function findByGalleryId($id)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $query = $qb
            ->select('t')
            ->from('DWIPortfolioBundle:Tag', 't')
            ->innerJoin('t.galleries', 'g')
            ->where('g.id = :id')
            ->orderBy('t.name', 'ASC')
            ->setParameter('id', $id)
            ->getQuery();

        return $query->useResultCache(true)
            ->getResult();
    }


    /**
     * Find primary tags
     *
     * @return object
     */
    public function findPrimary()
    {
        $query = $this->createQueryBuilder('t')
            ->where('t.isPrimary = 1')
            ->orderBy('t.name', 'ASC')
            ->getQuery();

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
