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
 * Image Gateway
 */
class ImageGateway extends AbstractGateway
{
    /**
     * Update order of total gallery
     *
     * @param  integer $galleryId
     * @param  array   $order
     * @return integer
     */
    public function updateGalleryOrder($galleryId, $order)
    {
        $this->conn->beginTransaction();

        try {
            foreach ($order as $position => $id) {
                $this->updateOrder($galleryId, $id, ($position + 1));
            }

            $this->conn->commit();
            $this->cache->deleteAll();

            return true;
        } catch (\Exception $e) {
            $this->conn->rollback();
            throw $e;
        }
    }


    /**
     * Update Image Order
     *
     * @param  integer $id
     * @param  integer $order
     * @return
     */
    public function updateOrder($galleryId, $id, $order)
    {
        $qb = $this->conn->createQueryBuilder();

        $qb->update('Image', 'i');
        $qb->set('i.displayOrder', ':order');
        $qb->where('i.galleryId = :galleryId');
        $qb->andWhere('i.id = :id');
        $qb->setParameter('order', $order);
        $qb->setParameter('galleryId', $galleryId);
        $qb->setParameter('id', $id);

        return $qb->execute();
    }
}
