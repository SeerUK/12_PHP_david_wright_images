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
use DWI\PortfolioBundle\Entity\Gallery;
use DWI\PortfolioBundle\Form\Type\GalleryType;

/**
 * Gallery Form Factory
 */
class GalleryFormFactory extends AbstractFormFactory
{
    /**
     * @var Gallery
     */
    private $gallery;


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

        $this->gallery = new Gallery();
        $this->gallery->setDate(new \DateTime());

        $this->generator = $generator;
    }


    /**
     * Prepare the form
     *
     * @return Form
     */
    public function prepareForm()
    {
        $form = $this->ff->create(new GalleryType(), $this->gallery);

        return $form;
    }


    /**
     * Set gallery
     *
     * @param  Gallery $gallery
     * @return GalleryFormFactory
     */
    public function setGallery(Gallery $gallery)
    {
        $this->gallery = $gallery;

        return $this;
    }
}
