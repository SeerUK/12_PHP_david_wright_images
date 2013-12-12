<?php

/**
 * David Wright Images
 *
 * @author  Elliot Wright <wright.elliot@gmail.com>
 * @since   2013
 * @package DWI
 */

namespace DWI\CoreBundle\Model;

/**
 * Clearable Model Interface
 */
interface ClearableModelInterface
{
    public function clearChildren();
    public function clearVariables();
}