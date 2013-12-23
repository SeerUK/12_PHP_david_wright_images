<?php

/**
 * David Wright Images
 *
 * @author  Elliot Wright <wright.elliot@gmail.com>
 * @since   2013
 * @package DWI
 */

namespace DWI\CoreBundle\Gateway;

use Doctrine\Common\Cache\CacheProvider;
use Doctrine\DBAL\Connection;

/**
 * Gallery View Gateway
 */
abstract class AbstractGateway
{
    /**
     * @var CacheProvider
     */
    protected $cache;


    /**
     * @var Connection
     */
    protected $conn;


    /**
     * Constructor
     *
     * @param Connection    $conn
     * @param CacheProvider $cache
     */
    public function __construct(Connection $conn, CacheProvider $cache)
    {
        $this->conn  = $conn;
        $this->cache = $cache;
    }
}
