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
     * Persist Image
     *
     * @param  Image $entity
     * @return ImageRepository
     */
    public function persist($entity)
    {
        if ( ! $this->isEntityType($entity)) {
            throw new \InvalidArgumentException(
                __METHOD__ .
                ' expected an instance of DWI\PortfolioBundle\Entity\Image. Received ' .
                gettype($entity)
            );
        }

        $em = $this->getEntityManager();
        $em->persist($entity);
        $em->flush();

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
