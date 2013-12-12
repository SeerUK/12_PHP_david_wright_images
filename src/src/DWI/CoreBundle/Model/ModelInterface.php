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
 * Model Interface
 */
interface ModelInterface
{
    public function setVariable($name, $value);
    public function setVariables($variables);
    public function getVariable($name, $default = null);
    public function getVariables();
    public function addChild(ModelInterface $child, $captureTo);
    public function getChild($name);
    public function getChildren();
    public function hasChildren();
}