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
    public function createPortfolioView(array $galleries)
    {
        $portfolio = array();

        foreach ($galleries as $gallery) {
            if (!$gallery instanceof Gallery) {
                throw new InvalidDataTypeException('$gallery not an instance of DWI\PortfolioBundle\Entity\Gallery.');
            }

            // Populate view model with data we need in the view
            $pgvm = new PortfolioGalleryViewModel();
            $pgvm->setId($gallery->getId())
                ->setTitle($gallery->getTitle())
                ->setCoverImagePath($this->getGalleryCoverImagePath($gallery));

            $portfolio['galleries'][] = $pgvm;
        }

        return $portfolio;
    }

    /**
     * Get gallery cover image path
     *
     * @param  DWI\PortfolioBundle\Entity\Gallery $gallery
     * @return string | false
     */
    private function getGalleryCoverImagePath($gallery)
    {
        if ($ci = $gallery->getCoverImage()) {
            return $ci->getImage()->getWebThumbPath();
        }

        return false;
    }
}
