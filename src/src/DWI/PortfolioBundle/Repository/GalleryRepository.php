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
     * Number of galleries per-age
     */
    const PER_PAGE = 9;


    /**
     * Find galleries by id
     *
     * @param  integer $id
     * @param  array   $options
     * @return DWI\PortfolioBundle\Entity\Gallery
     */
    public function findById($id, array $options = null)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $query = $qb
            ->select('g, gci, gi, t, gv')
            ->from('DWIPortfolioBundle:Gallery', 'g')
            ->leftJoin('g.coverImage', 'gci')
            ->leftJoin('g.images', 'gi')
            ->leftJoin('g.tags', 't')
            ->leftJoin('g.views', 'gv')
            ->where('g.id = :id')
            ->setParameter('id', $id);

        $query = $this->augmentQueryFromOptions($query, $options);

        return $query->getQuery()
            ->useResultCache(true)
            ->getSingleResult();
    }


    /**
     * Find galleries by page
     *
     * @param  integer $page
     * @param  array   $options
     * @return array
     */
    public function findByPage($page, array $options = null)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $query = $qb
            ->select('g, gci, gcii, t, gv')
            ->from('DWIPortfolioBundle:Gallery', 'g')
            // ->leftJoin('g.coverImage', 'gci')
            // ->leftJoin('gci.image', 'gcii')
            // ->leftJoin('g.tags', 't')
            // ->leftJoin('g.views', 'gv')
            ->orderBy('g.id', 'DESC');

        $query  = $this->augmentQueryFromOptions($query, $options);
        $offset = $this->getPageFirstResult($page, self::PER_PAGE);

        return $query->getQuery()
            ->setFirstResult($offset)
            ->setMaxResults(self::PER_PAGE)
            ->useResultCache(true)
            ->getResult();
    }


    /**
     * Find most recent galleries with limit
     *
     * @param  integer $limit
     * @param  array   $options
     * @return array
     */
    public function findWithLimit($limit, array $options = null)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $query = $qb
            ->select('g, gci, gcii')
            ->from('DWIPortfolioBundle:Gallery', 'g')
            ->leftJoin('g.coverImage', 'gci')
            ->leftJoin('gci.image', 'gcii')
            ->orderBy('g.id', 'DESC');

        $query  = $this->augmentQueryFromOptions($query, $options);

        return $query->getQuery()
            ->setMaxResults($limit)
            ->useResultCache(true)
            ->getResult();
    }


    /**
     * Augment given query with given options
     *
     * @param  QueryBuilder $query
     * @param  array        $options
     * @return QueryBuilder
     */
    private function augmentQueryFromOptions($query, $options)
    {
        if (is_array($options)) {
            if (isset($options['isActive'])) {
                $query->andWhere('g.isActive = :isActive')
                    ->setParameter('isActive', $options['isActive']);
            }

            if (isset($options['tagId'])) {
                $query->andWhere('t.id = :tagId')
                    ->setParameter('tagId', $options['tagId']);
            }
        }

        return $query;
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
                ' expected an instance of DWI\PortfolioBundle\Entity\Gallery. Received ' .
                gettype($entity)
            );
        }

        $em = $this->getEntityManager();
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
