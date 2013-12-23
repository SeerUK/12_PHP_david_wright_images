<?php

/**
 * David Wright Images
 *
 * @author  Elliot Wright <wright.elliot@gmail.com>
 * @since   2013
 * @package DWI
 */

namespace DWI\PortfolioBundle\Gateway;

use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManager;

/**
 * Gallery View Gateway
 */
class GalleryViewGateway
{
    /**
     * @var CacheProvider
     */
    private $cache;


    /**
     * @var Connection
     */
    private $conn;


    /**
     * Constructor
     *
     * @param Connection $conn
     */
    public function __construct(Connection $conn, EntityManager $em)
    {
        $this->conn  = $conn;
        $this->cache = $em->getConfiguration()->getResultCacheImpl();
    }


    /**
     * Find gallery views by id
     *
     * @param  integer $id
     * @return integer
     */
    public function findByGalleryId($id)
    {
        $ck = __CLASS__ . ':' . __METHOD__ . ':' . $id;

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
        $ck = __CLASS__ . ':' . __METHOD__;

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
}
