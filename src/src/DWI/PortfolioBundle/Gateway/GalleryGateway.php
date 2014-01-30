<?php

/**
 * David Wright Images
 *
 * @author  Elliot Wright <wright.elliot@gmail.com>
 * @since   2013
 * @package DWI
 */

namespace DWI\PortfolioBundle\Gateway;

use DWI\CoreBundle\Gateway\AbstractGateway;

/**
 * Gallery Gateway
 */
class GalleryGateway extends AbstractGateway
{
    /**
     * Count total galleries
     *
     * @param  array $options
     * @return integer
     */
    public function countTotal(array $options = null)
    {
        $qb = $this->conn->createQueryBuilder();

        $qb->select('COUNT(g.id) AS galleries');
        $qb->from('Gallery', 'g');

        $qb     = $this->augmentQueryFromOptions($qb, $options);
        $result = $qb->execute()->fetch();

        return $result['galleries']
            ? $result['galleries']
            : 0;
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
                $query
                    ->leftJoin('g', 'GalleryTag', 'gt', 'g.id = gt.galleryId')
                    ->andWhere('gt.tagId = :tagId')
                    ->setParameter('tagId', $options['tagId']);
            }
        }

        return $query;
    }
}
