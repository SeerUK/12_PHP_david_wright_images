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
use DWI\PortfolioBundle\Entity\Image;

/**
 * Image Repository
 */
class ImageRepository extends EntityRepository implements PersistentEntityRepository
{
    /**
     * Find images by gallery ID
     *
     * @param  integer $id
     * @return array
     */
    public function findByGalleryId($id, array $options = null)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $query = $qb
            ->select('i')
            ->from('DWIPortfolioBundle:Image', 'i')
            ->innerJoin('i.gallery', 'g')
            ->where('g.id = :id')
            ->orderBy('i.displayOrder', 'ASC')
            ->setParameter('id', $id);

        $query = $this->augmentQueryFromOptions($query, $options);

        return $query->getQuery()
            ->useResultCache(true)
            ->getResult();
    }


    /**
     * Find an image by gallery ID and display order
     *
     * @param  integer $id
     * @param  integer $displayOrder
     * @return Image
     */
    public function findOneByGalleryIdAndDisplayOrder($id, $displayOrder)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $query = $qb
            ->select('i')
            ->from('DWIPortfolioBundle:Image', 'i')
            ->innerJoin('i.gallery', 'g')
            ->where('g.id = :id')
            ->andWhere('i.displayOrder = :displayOrder')
            ->orderBy('i.displayOrder', 'ASC')
            ->setParameter('id', $id)
            ->setParameter('displayOrder', $displayOrder);

        return $query->getQuery()
            ->useResultCache(true)
            ->setMaxResults(1)
            ->getSingleResult();
    }


    /**
     * Swap an image's display order with anothers
     *
     * @param  integer $id   [description]
     * @param  integer $from [description]
     * @param  integer $to   [description]
     * @return ImageRepository
     */
    public function swapImageDisplayOrderByGalleryId($id, $from, $to)
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();

        $em->getConnection()->beginTransaction();

        try {
            $fromImage = $this->findOneByGalleryIdAndDisplayOrder($id, $from);
            $toImage   = $this->findOneByGalleryIdAndDisplayOrder($id, $to);

            $fromPosition = $fromImage->getDisplayOrder();
            $toPosition   = $toImage->getDisplayOrder();

            $fromImage->setDisplayOrder($toPosition);
            $toImage->setDisplayOrder($fromPosition);

            $em->flush();
            $em->getConnection()->commit();
        } catch (\Exception $e) {
            $em->getConnection()->rollback();
            $em->close();
            throw $e;
        }

        // Clear cache
        $cd = $em->getConfiguration()->getResultCacheImpl();
        $cd->deleteAll();

        return $this;
    }


    /**
     * Find the next display order position by gallery ID, should be
     * used in a transaction, used internally.
     *
     * @param  integer $id
     * @return integer
     */
    private function findNextDisplayOrderPositionByGalleryId($id)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $query = $qb
            ->select('i')
            ->from('DWIPortfolioBundle:Image', 'i')
            ->innerJoin('i.gallery', 'g')
            ->where('g.id = :id')
            ->orderBy('i.displayOrder', 'DESC')
            ->setParameter('id', $id);

        try {
            $image = $query->getQuery()
                ->setMaxResults(1)
                ->getSingleResult();

            return $image->getDisplayOrder() + 1;
        } catch (NoResultException $e) {
            return 1;
        }
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
                $query->andWhere('i.isActive = :isActive')
                    ->setParameter('isActive', $options['isActive']);
            }
        }

        return $query;
    }


    /**
     * Persist Image (create new)
     *
     * @param  Image $entity
     * @return ImageRepository
     */
    public function persist($image)
    {
        if ( ! $this->isEntityType($image)) {
            throw new \InvalidArgumentException(
                __METHOD__ .
                ' expected an instance of DWI\PortfolioBundle\Entity\Image. Received ' .
                gettype($image)
            );
        }

        $em = $this->getEntityManager();
        $em->getConnection()->beginTransaction();

        try {
            $image->setDisplayOrder($this->findNextDisplayOrderPositionByGalleryId(
                $image->getGallery()->getId()
            ));

            $em->persist($image);
            $em->flush();
            $em->getConnection()->commit();
        } catch (\Exception $e) {
            $em->getConnection()->rollback();
            $em->close();
            throw $e;
        }

        // Clear query cache so that subsequent requests for Image objects
        // don't return ghosts
        $cd = $em->getConfiguration()->getResultCacheImpl();
        $cd->deleteAll();

        return $this;
    }


    /**
     * Update Image
     *
     * @param  Image $entity
     * @return ImageRepository
     */
    public function update($entity)
    {
        if ( ! $this->isEntityType($entity)) {
            throw new \InvalidArgumentException(
                __METHOD__ .
                ' expected an instance of DWI\PortfolioBundle\Entity\Image. Received ' .
                gettype($entity)
            );
        }

        $em = $this->getEntityManager();
        $em->flush();

        // Clear query cache so that subsequent requests for Image objects
        // don't return ghosts
        $cd = $em->getConfiguration()->getResultCacheImpl();
        $cd->deleteAll();

        return $this;
    }


    /**
     * Remove Image
     *
     * @param  Image $entity
     * @return ImageRepository
     */
    public function remove($entity)
    {
        if ( ! $this->isEntityType($entity)) {
            throw new \InvalidArgumentException(
                __METHOD__ .
                ' expected an instance of DWI\PortfolioBundle\Entity\Image. Received ' .
                gettype($entity)
            );
        }

        $em = $this->getEntityManager();
        $em->remove($entity);
        $em->flush();

        // Clear query cache so that subsequent requests for Image objects
        // don't return ghosts
        $cd = $em->getConfiguration()->getResultCacheImpl();
        $cd->deleteAll();

        return $this;
    }


    /**
     * Is the given entity an instance of Image?
     *
     * @param  mixed   $entity
     * @return boolean
     */
    public function isEntityType($entity)
    {
        return ($entity instanceof Image)
            ? true
            : false;
    }
}
