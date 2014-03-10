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
 * Gallery View Gateway
 */
class GalleryViewGateway extends AbstractGateway
{
    /**
     * Find all views
     *
     * @return  integer
     */
    public function find()
    {
        $ck = __METHOD__;

        // Fetch cached result, or recache
        if ( ! (bool) $result = $this->cache->fetch($ck)) {
            $qb = $this->conn->createQueryBuilder();

            $qb->select('COALESCE(SUM(gv.views), 0) AS views');
            $qb->from('GalleryView', 'gv');

            $stmt = $this->conn->prepare($qb->getSql());
            $stmt->execute();

            $result = $stmt->fetch();

            $this->cache->save($ck, $result);
        }

        return $result['views']
            ? $result['views']
            : 0;
    }


    /**
     * Find gallery views by id
     *
     * @param  integer $id
     * @return integer
     */
    public function findByGalleryId($id)
    {
        if ( ! filter_var($id, FILTER_VALIDATE_INT)) {
            throw new \InvalidArgumentException(
                __METHOD__ .
                ' expected an integer. Received ' .
                gettype($id)
            );
        }

        $ck = __METHOD__ . ':' . $id;

        // Fetch cached result, or recache
        if ( ! (bool) $result = $this->cache->fetch($ck)) {
            $qb = $this->conn->createQueryBuilder();

            $qb->select('COALESCE(SUM(gv.views), 0) AS views');
            $qb->from('GalleryView', 'gv');
            $qb->where('gv.galleryId = :id');

            $stmt = $this->conn->prepare($qb->getSql());
            $stmt->bindValue('id', $id);
            $stmt->execute();

            $result = $stmt->fetch();

            $this->cache->save($ck, $result);
        }

        return $result['views']
            ? $result['views']
            : 0;
    }


    /**
     * Find dated gallery views
     *
     * @param  integer $limit
     * @return integer
     */
    public function findDated($limit = 30)
    {
        if ( ! filter_var($limit, FILTER_VALIDATE_INT)) {
            throw new \InvalidArgumentException(
                __METHOD__ .
                ' \'limit\'expected an integer. Received ' .
                gettype($limit)
            );
        }

        $ck = __METHOD__ . ':' . $limit;

        // Fetch cached result, or recache
        if ( ! (bool) $result = $this->cache->fetch($ck)) {
            $qb = $this->conn->createQueryBuilder();

            $qb->select('SUM(COALESCE(gv.views, 0)) AS views', 'gv.date');
            $qb->from('GalleryView', 'gv');
            $qb->groupBy('date');
            $qb->orderBy('date', 'DESC');
            $qb->setMaxResults($limit);

            $stmt = $this->conn->prepare($qb->getSql());
            $stmt->execute();

            $result = $stmt->fetchAll();

            $this->cache->save($ck, $result);
        }

        return $result;
    }


    /**
     * Find dated gallery views by id
     *
     * @param  integer $id
     * @param  integer $limit
     * @return integer
     */
    public function findDatedByGalleryId($id, $limit = 30)
    {
        if ( ! filter_var($id, FILTER_VALIDATE_INT)) {
            throw new \InvalidArgumentException(
                __METHOD__ .
                ' \'id\'expected an integer. Received ' .
                gettype($id)
            );
        }

        if ( ! filter_var($limit, FILTER_VALIDATE_INT)) {
            throw new \InvalidArgumentException(
                __METHOD__ .
                ' \'limit\'expected an integer. Received ' .
                gettype($limit)
            );
        }

        $ck = __METHOD__ . ':' . $id . ':' . $limit;

        // Fetch cached result, or recache
        if ( ! (bool) $result = $this->cache->fetch($ck)) {
            $qb = $this->conn->createQueryBuilder();

            $qb->select('COALESCE(gv.views, 0) AS views', 'gv.date');
            $qb->from('GalleryView', 'gv');
            $qb->where('gv.galleryId = :id');
            $qb->groupBy('date');
            $qb->orderBy('date', 'DESC');
            $qb->setMaxResults($limit);

            $stmt = $this->conn->prepare($qb->getSql());
            $stmt->bindValue('id', $id);
            $stmt->execute();

            $result = $stmt->fetchAll();

            $this->cache->save($ck, $result);
        }

        return $result;
    }


    /**
     * Find total gallery views
     *
     * @return integer
     */
    public function findTotal()
    {
        $ck = __METHOD__;

        // Fetch cached result, or recache
        if ( ! (bool) $result = $this->cache->fetch($ck)) {
            $qb = $this->conn->createQueryBuilder();

            $qb->select('COALESCE(SUM(gv.views), 0) AS views');
            $qb->from('GalleryView', 'gv');

            $stmt   = $this->conn->prepare($qb->getSql());
            $stmt->execute();

            $result = $stmt->fetch();

            $this->cache->save($ck, $result);
        }

        return $result['views']
            ? $result['views']
            : 0;
    }


    /**
     * Find total views of galleries with given tag ID
     *
     * @param  integer $tagId
     * @return integer
     */
    public function findTotalByTagId($tagId)
    {
        if ( ! filter_var($tagId, FILTER_VALIDATE_INT)) {
            throw new \InvalidArgumentException(
                __METHOD__ .
                ' expected an integer. Received ' .
                gettype($tagId)
            );
        }

        $qb = $this->conn->createQueryBuilder();

        $qb->select('COALESCE(SUM(gv.views), 0) AS views');
        $qb->from('GalleryView', 'gv');
        $qb->leftJoin('gv', 'Gallery', 'g', 'g.id = gv.galleryId');
        $qb->leftJoin('g', 'GalleryTag', 'gt', 'gt.galleryId = g.id');
        $qb->where('gt.tagId = :tagId');

        $stmt = $this->conn->prepare($qb->getSql());
        $stmt->bindValue('tagId', $tagId);
        $stmt->execute();

        $result = $stmt->fetch();

        return $result['views']
            ? $result['views']
            : 0;
    }


    /**
     * Record view by gallery id
     *
     * @param  integer $id
     */
    public function recordByGalleryId($id)
    {
        if ( ! filter_var($id, FILTER_VALIDATE_INT)) {
            throw new \InvalidArgumentException(
                __METHOD__ .
                ' expected an integer. Received ' .
                gettype($id)
            );
        }

        $ck = __METHOD__ . ':' . $id;

        $sql = '
            INSERT INTO
                GalleryView (galleryId, views, date)
            VALUES
                (:id, 1, NOW())
            ON DUPLICATE KEY UPDATE
                views = views + 1';

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue('id', $id);
        $stmt->execute();

        $this->cache->deleteAll();
    }
}
