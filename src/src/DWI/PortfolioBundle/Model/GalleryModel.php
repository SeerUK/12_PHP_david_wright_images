<?php

/**
 * David Wright Images
 *
 * @author  Elliot Wright <wright.elliot@gmail.com>
 * @since   2013
 * @package DWI
 */

namespace DWI\PortfolioBundle\Model;

use DWI\PortfolioBundle\ViewModel\GalleryViewModel;

/**
 * Gallery Model
 */
class GalleryModel
{
    public function createGalleryView($gallery)
    {
        $gvm = new GalleryViewModel();
        $gvm->setTitle($gallery->getTitle())
            ->setSubtitle($gallery->getSubtitle())
            ->setDescription($gallery->getDescription())
            ->setDate($gallery->getDate())
            ->setImages($gallery->getImages());

        return $gvm;
    }
}
