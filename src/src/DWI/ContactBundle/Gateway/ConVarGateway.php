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
    /**
     * Get config var value by name
     *
     * @param  string $name
     * @return multi
     */
    public function findByName($name)
    {
        $qb = $this->conn->createQueryBuilder();

        $qb->select('cv.value');
        $qb->from('ConVar', 'cv');

        $result = $qb->execute()->fetch();

        return $result['value'];
    }


    /**
     * Update config var value by name
     *
     * @param  string $name
     * @param  string $value
     * @return ?
     */
    public function updateByName($name, $value)
    {
        $qb = $this->conn->createQueryBuilder();

        $qb->update('ConVar', 'cv');
        $qb->set('value', ':value');
        $qb->where('name = :name');

        $stmt = $this->conn->prepare($qb->getSql());
        $stmt->bindValue('value', $value);
        $stmt->bindValue('name', $name);

        return $stmt->execute();
    }
}
