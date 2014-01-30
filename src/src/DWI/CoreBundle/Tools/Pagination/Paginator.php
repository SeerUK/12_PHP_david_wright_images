<?php

/**
 * David Wright Images
 *
 * @author  Elliot Wright <wright.elliot@gmail.com>
 * @since   2013
 * @package DWI
 */

namespace DWI\CoreBundle\Tools\Pagination;

/**
 * Paginator
 */
class Paginator
{
    /**
     * Max pages to be displayed at once
     */
    const AT_ONCE = 10;


    /**
     * @var integer
     */
    private $pages;


    /**
     * Constructor
     *
     * @param integer $pages
     */
    public function __construct($pages)
    {
        $this->pages = (int) $pages;
    }


    /**
     * Calculate start page number
     *
     * @param  integer $page
     * @return integer
     */
    public function calculateStart($page)
    {
        if ($this->pages <= self::AT_ONCE) { // Less than total pages to be seen at once
            $start = 1;
        } else { // More than total pages to be seen at once
            $projectedStart = $page - (self::AT_ONCE / 2);
            if ($projectedStart < 1) {
                $start = 1;
            } else {
                $start = $projectedStart;
            }
        }

        return $start;
    }


    /**
     * Calculate end page number
     *
     * @param  integer $page
     * @return integer
     */
    public function calculateEnd($page)
    {
        if ($this->pages <= self::AT_ONCE) { // Less than total pages to be seen at once
            $end = $this->pages;
        } else { // More than total pages to be seen at once
            $projectedEnd = $page + (self::AT_ONCE / 2);
            if ($projectedEnd > $this->pages) {
                $end = $this->pages;
            } else {
                $end = $projectedEnd;
            }
        }

        return $end;
    }
}