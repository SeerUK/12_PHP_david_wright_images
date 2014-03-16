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


    /**
     * Update content for page by page name
     *
     * @param  string $name
     * @param  string $content
     * @return ?
     */
    public function updateContentByName($name, $content)
    {
        $sql = "
            REPLACE INTO
                Page (name, content)
            VALUES
                (:name, :content)
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue('name', $name);
        $stmt->bindValue('content', $content);

        return $stmt->execute();
    }
}
