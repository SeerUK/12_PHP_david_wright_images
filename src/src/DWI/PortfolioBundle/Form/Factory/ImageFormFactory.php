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
use DWI\PortfolioBundle\Entity\Image;
use DWI\PortfolioBundle\Form\Type\ImageType;

/**
 * Image Form Factory
 */
class ImageFormFactory extends AbstractFormFactory
{
    /**
     * @var Image
     */
    private $image;


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

        $this->image     = new Image();
        $this->generator = $generator;
    }


    /**
     * Prepare the form
     *
     * @return Form
     */
    public function prepareForm()
    {
        $form = $this->ff->create(new ImageType(), $this->image);

        return $form;
    }


    /**
     * Set gallery
     *
     * @param  Image $image
     * @return ImageFormFactory
     */
    public function setGallery(Image $image)
    {
        $this->image = $image;

        return $this;
    }
}
