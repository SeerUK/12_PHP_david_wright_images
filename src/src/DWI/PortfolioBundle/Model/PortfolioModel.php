<?php

/**
 * David Wright Images
 *
 * @author  Elliot Wright <wright.elliot@gmail.com>
 * @since   2013
 * @package DWI
 */

namespace DWI\PortfolioBundle\Model;

use DWI\PortfolioBundle\Exception\InvalidDataTypeException;
use DWI\PortfolioBundle\Entity\CoverImage;
use DWI\PortfolioBundle\Entity\Gallery;
use DWI\PortfolioBundle\Entity\Image;
use DWI\PortfolioBundle\ViewModel\PortfolioGalleryViewModel;

/**
 * Portfolio Model
 */
class PortfolioModel
{
    /**
     * Get galleries
     *
     * @return array
     */
    public function createPortfolioView($galleries)
    {
        $portfolio = array();

        foreach ($galleries as $gallery) {
            if (!$gallery instanceof Gallery) {
                throw new InvalidDataTypeException('$gallery not an instance of DWI\PortfolioBundle\Entity\Gallery.');
            }

            $pvm = new PortfolioGalleryViewModel();
            $pvm->setId($gallery->getId())
                ->setName($gallery->getName())
                ->setImagePath($gallery->getCoverImage()->getImage()->getPath());

            $portfolio[] = $pvm;
        }

        return $portfolio;
    }
}
