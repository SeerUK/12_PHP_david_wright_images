<?php

/**
 * David Wright Images
 *
 * @author  Elliot Wright <wright.elliot@gmail.com>
 * @since   2013
 * @package DWI
 */

namespace DWI\CoreBundle\View\Presenter;

/**
 * Presenter
 */
abstract class AbstractPresenter
{
    abstract public function prepareView();


    /**
     * @var array
     */
    private $variables = array();


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
     * Set view variable
     *
     * @param  string $name
     * @param  mixed  $value
     * @return AbstractPresenter
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
     * @return AbstractPresenter
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
     * Clear all view variables
     *
     * @return AbstractPresenter
     */
    public function clearVariables()
    {
        $this->variables = array();

        return $this;
    }
}
