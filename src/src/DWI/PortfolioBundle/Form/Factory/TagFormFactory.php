<?php

/**
 * David Wright Images
 *
 * @author  Elliot Wright <wright.elliot@gmail.com>
 * @since   2013
 * @package DWI
 */

namespace DWI\PortfolioBundle\Form\Factory;

use Symfony\Component\Form\FormFactory;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use DWI\CoreBundle\Form\Factory\AbstractFormFactory;
use DWI\PortfolioBundle\Entity\Tag;
use DWI\PortfolioBundle\Form\Type\TagType;

/**
 * Tag Form Factory
 */
class TagFormFactory extends AbstractFormFactory
{
    /**
     * @var Tag
     */
    private $tag;


    /**
     * @var UrlGeneratorInterface
     */
    private $generator;


    /**
     * Constructor
     *
     * @param FormFactory           $ff
     * @param UrlGeneratorInterface $generator
     */
    public function __construct(FormFactory $ff, UrlGeneratorInterface $generator)
    {
        parent::__construct($ff);

        $this->tag       = new Tag();
        $this->generator = $generator;
    }


    /**
     * Prepare the form
     *
     * @return Form
     */
    public function prepareForm()
    {
        $form = $this->ff->create(new TagType(), $this->tag);

        return $form;
    }


    /**
     * Set tag
     *
     * @param  Tag $tag
     * @return TagFormFactory
     */
    public function setTag(Tag $tag)
    {
        $this->tag = $tag;

        return $this;
    }
}
