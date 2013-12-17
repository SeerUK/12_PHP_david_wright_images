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

        $this->generator = $generator;
    }


    /**
     * Prepare the form
     *
     * @return Form
     */
    public function prepareForm()
    {
        $gallery = new Gallery();
        $gallery->setDate(new \DateTime());

        $form = $this->ff->create(new GalleryType(), $gallery, array(
            'action' => $this->generator->generate('dwi_portfolio_create_gallery'),
        ));

        return $form;
    }
}
