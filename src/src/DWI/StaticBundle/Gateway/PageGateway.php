<?php

/**
 * David Wright Images
 *
 * @author  Elliot Wright <wright.elliot@gmail.com>
 * @since   2013
 * @package DWI
 */

namespace DWI\StaticBundle\Gateway;

use DWI\CoreBundle\Gateway\AbstractGateway;

/**
 * Page Gateway
 */
class PageGateway extends AbstractGateway
{
    /**
     * Find content for page by page name
     *
     * @param  string $name
     * @return string|bool
     */
    public function findContentByName($name)
    {
        $qb = $this->conn->createQueryBuilder();

        $qb->select('content');
        $qb->from('Page', 'p');
        $qb->where('name = :name');

        $stmt = $this->conn->prepare($qb->getSql());
        $stmt->bindValue('name', $name);
        $stmt->execute();

        $result = $stmt->fetch();

        return $result['content']
            ? $result['content']
            : false;
    }
}
