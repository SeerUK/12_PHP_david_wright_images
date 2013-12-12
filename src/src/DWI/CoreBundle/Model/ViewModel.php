<?php

/**
 * David Wright Images
 *
 * @author  Elliot Wright <wright.elliot@gmail.com>
 * @since   2013
 * @package DWI
 */

namespace DWI\CoreBundle\Model;

use DWI\CoreBundle\Model\ClearableModelInterface;
use DWI\CoreBundle\Model\ModelInterface,

/**
 * View Model
 */
class ViewModel implements ModelInterface, ClearableModelInterface
{
    /**
     * @var array
     */
    private $children = array();


    /**
     * @var array
     */
    private $variables = array();


    /**
     * Constructor
     *
     * @param null|array $variables
     */
    public function __construct($variables = null)
    {
        if (null !== $variables) {
            $this->setVariables($variables);
        }
    }


    /**
     * Magic get variable value
     *
     * @param  string $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->getVariable($name);
    }


    /**
     * Magic view variables setter
     *
     * @param string $name
     * @param mixed  $value
     */
    public function __set($name, $value)
    {
        $this->setVariable($name, $value);
    }


    /**
     * Magic check for if variable exists
     *
     * @param  string  $name
     * @return boolean
     */
    public function __isset($name)
    {
        $variables = $this->getVariables();

        return isset($variables[$name]);
    }


    /**
     * Magic unset the requested variable
     *
     * @param  string $name
     * @return void
     */
    public function __unset($name)
    {
        if ( ! $this->__isset($name)) {
            return null;
        }

        unset($this->variables[$name]);
    }


    /**
     * Set view variable
     *
     * @param  string $name
     * @param  mixed  $value
     * @return AbstractViewModel
     */
    public function setVariable($name, $value)
    {
        $this->variables[(string) $name] = $value;

        return $this;
    }


    /**
     * Sets view variables en masse
     *
     * @param  array $variables
     * @return AbstractViewModel
     */
    public function setVariables($variables)
    {
        if ( ! is_array($variables)) {
            throw new \InvalidArgumentException(sprintf(
                '%s: expects an array; received "%s"',
                __METHOD__,
                (is_object($variables) ? get_class($variables) : gettype($variables))
            ));
        }

        foreach ($variables as $key => $value)
        {
            $this->setVariable($key, $value);
        }

        return $this;
    }


    /**
     * Get a view variable
     *
     * @param  string     $name
     * @param  mixed|null $default
     * @return mixed
     */
    public function getVariable($name, $default = null)
    {
        $name = (string) $name;

        if (array_key_exists($name, $this->variables)) {
            return $this->variables[$name];
        }

        return $default;
    }


    /**
     * Get view variables
     *
     * @return array
     */
    public function getVariables()
    {
        return $this->variables;
    }


    /**
     * Clear all view variables
     *
     * @return AbstractViewModel
     */
    public function clearVariables()
    {
        $this->variables = array();

        return $this;
    }


    /**
     * Add a child model
     *
     * @param  ModelInterface $child
     * @param  null|string    $captureTo
     * @return ViewModel
     */
    public function addChild(ModelInterface $child, $captureTo = null)
    {
        if (null !== $captureTo) {
            $this->children[(string) $captureTo] = $child;
        } else {
            $this->children[] = $child;
        }

        return $this;
    }


    /**
     * Get a child model
     *
     * @param  string $name
     * @return null|ModelInterface
     */
    public function getChild($name)
    {
        $name = (string) $name;

        if (array_key_exists($name, $this->children)) {
            return $this->children[$name];
        }

        return null;
    }


    /**
     * Get all child models
     *
     * @return array
     */
    public function getChildren()
    {
        return $this->children;
    }


    /**
     * Does this model have any children?
     *
     * @return boolean
     */
    public function hasChildren()
    {
        return (0 < count($this->children));
    }


    /**
     * Clear all child models
     *
     * @return ViewModel
     */
    public function clearChildren()
    {
        $this->children = array();

        return $this;
    }
}
