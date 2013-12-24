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
            $sql = '
                SELECT
                    COALESCE(gv.views, 0) AS views
                FROM
                    GalleryView AS gv
                WHERE
                    gv.galleryId = :id';

            $stmt = $this->conn->prepare($sql);
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
     * Find total gallery views
     *
     * @return integer
     */
    public function findTotal()
    {
        $ck = __METHOD__;

        // Fetch cached result, or recache
        if ( ! (bool) $result = $this->cache->fetch($ck)) {
            $sql = '
                SELECT
                    COALESCE(SUM(views), 0) AS views
                FROM
                    GalleryView';

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();

            $result = $stmt->fetch();

            $this->cache->save($ck, $result);
        }

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
                GalleryView (galleryId, views)
            VALUES
                (:id, 1)
            ON DUPLICATE KEY UPDATE
                views = views + 1';

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue('id', $id);
        $stmt->execute();

        $this->destroyCacheByGalleryId($id)
            ->destroyTotalCache();
    }


    /**
     * Destroys cached views of a gallery
     *
     * @param  integer $id
     * @return GalleryViewGateway
     */
    public function destroyCacheByGalleryId($id)
    {
        $this->cache->delete(get_called_class() . '::findByGalleryId:' . $id);

        return $this;
    }


    /**
     * Destroy total gallery view cache
     *
     * @return GalleryViewGateway
     */
    public function destroyTotalCache()
    {
        $this->cache->delete(get_called_class() . '::findTotal');

        return $this;
    }
}
