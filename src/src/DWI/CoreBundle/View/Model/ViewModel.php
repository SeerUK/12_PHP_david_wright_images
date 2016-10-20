<?php

/**
 * David Wright Images
 *
 * @author  Elliot Wright <wright.elliot@gmail.com>
 * @since   2013
 * @package DWI
 */

namespace DWI\CoreBundle\View\Model;

use DWI\CoreBundle\Model\ClearableModelInterface;
use DWI\CoreBundle\Model\ModelInterface;

/**
 * View Model
 */
class ViewModel implements ModelInterface, ClearableModelInterface
{
    /**
     * @var string
     */
    protected $captureTo;


    /**
     * @var \ArrayObject
     */
    protected $children;


    /**
     * @var \ArrayObject
     */
    protected $variables;


    /**
     * Constructor
     *
     * @param null|array|\ArrayObject $variables
     */
    public function __construct($variables = null)
    {
        $this->children  = new \ArrayObject();
        $this->variables = new \ArrayObject();

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
     * Magic call method
     *
     * @param  string $name
     * @param  array $args
     * @return mixed
     */
    public function __call($name, $args)
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
     * Set captureTo
     *
     * @param  string $captureTo
     * @return ViewModel
     */
    public function setCaptureTo($captureTo)
    {
        $this->captureTo = (string) $captureTo;

        return $this;
    }


    /**
     * Get captureTo
     *
     * @return string
     */
    public function getCaptureTo()
    {
        return $this->captureTo;
    }


    /**
     * Set view variable
     *
     * @param  string $name
     * @param  mixed  $value
     * @return ViewModel
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
     * @return ViewModel
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

        foreach ($variables as $key => $value) {
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
     * @return ViewModel
     */
    public function clearVariables()
    {
        $this->variables = new \ArrayObject();

        return $this;
    }


    /**
     * Add a child model
     *
     * @param  ModelInterface $child
     * @param  null|string    $captureTo
     * @param  null|bool      $append
     * @return ViewModel
     */
    public function addChild(ModelInterface $child, $captureTo = null, $append = null)
    {
        $this->children[] = $child;

        if (null !== $captureTo) {
            $captureTo = (string) $captureTo;

            $this->setCaptureTo($captureTo);

            if ( ! $append) {
                // If we're simply storing the child with a name
                $this->setVariable($captureTo, $child);
            } else {
                // If we're creating a traversible object containing child model(s)
                $temp   = $this->getVariable($captureTo);
                $temp[] = $child;

                $this->setVariable($captureTo, $temp);
            }
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
     * Does this model have a specific child?
     *
     * @param  string  $name
     * @return boolean
     */
    public function hasChild($name)
    {
        if (array_key_exists((string) $name, $this->children)) {
            return true;
        }

        return false;
    }


    /**
     * Does this model have any children?
     *
     * @return boolean
     */
    public function hasChildren()
    {
        return (0 < $this->count());
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


    /**
     * Return count of children
     *
     * @return integer
     */
    public function count()
    {
        return count($this->children);
    }
}
