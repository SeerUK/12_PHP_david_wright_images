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

/**
 * Gallery View Gateway
 */
class GalleryViewGateway
{
    /**
     * @var Connection
     */
    private $conn;


    /**
     * Constructor
     *
     * @param Connection $conn
     */
    public function __construct(Connection $conn)
    {
        $this->conn = $conn;
    }


    /**
     * Find total gallery views
     *
     * @return integer
     */
    public function findTotalViews()
    {
        $sql = 'SELECT SUM(VIEWS) AS views FROM GalleryView';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $result = $stmt->fetch();

        return $result['views'];
    }
}
