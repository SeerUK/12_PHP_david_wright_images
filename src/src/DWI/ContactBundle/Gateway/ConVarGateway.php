<?php

/**
 * David Wright Images
 *
 * @author  Elliot Wright <wright.elliot@gmail.com>
 * @since   2013
 * @package DWI
 */

namespace DWI\ContactBundle\Gateway;

use DWI\CoreBundle\Gateway\AbstractGateway;

/**
 * ConVar Gateway
 */
class ConVarGateway extends AbstractGateway
{
    public function findByName($name)
    {
        $qb = $this->conn->createQueryBuilder();

        $qb->select('cv.value');
        $qb->from('ConVar', 'cv');

        $result = $qb->execute()->fetch();

        return $result['value'];
    }
}
