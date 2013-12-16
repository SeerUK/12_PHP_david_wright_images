<?php

/**
 * David Wright Images
 *
 * @author  Elliot Wright <wright.elliot@gmail.com>
 * @since   2013
 * @package DWI
 */

namespace DWI\CoreBundle\Form\Factory;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormFactory;

/**
 * Abstract Form Factory
 */
abstract class AbstractFormFactory
{
    /**
     * @var FormFactory
     */
    protected $ff;


    /**
     * Constructor
     *
     * @param Request $request
     */
    public function __construct(FormFactory $ff)
    {
        $this->ff = $ff;
    }


    abstract public function prepareForm();
}
