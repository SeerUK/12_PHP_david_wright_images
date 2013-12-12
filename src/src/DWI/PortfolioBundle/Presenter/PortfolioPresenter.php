<?php

/**
 * David Wright Images
 *
 * @author  Elliot Wright <wright.elliot@gmail.com>
 * @since   2013
 * @package DWI
 */

namespace DWI\PortfolioBundle\Presenter;

use DWI\CoreBundle\Exception\InvalidDataTypeException;
use DWI\CoreBundle\View\Model\ViewModel;
use DWI\PortfolioBundle\Entity\CoverImage;
use DWI\PortfolioBundle\Entity\Gallery;
use DWI\PortfolioBundle\Entity\Image;

/**
 * Portfolio Presenter
 */
class PortfolioPresenter extends AbstractPresenter
{
    /**
     * Get galleries
     *
     * @return array
     */
    public function createPortfolioView(array $galleries)
    {
        $portfolio = new ViewModel();

        foreach ($galleries as $gallery) {
            if ( ! $gallery instanceof Gallery) {
                throw new InvalidDataTypeException(
                    __METHOD__ . ' expected an instance of DWI\PortfolioBundle\Entity\Gallery. Received ' . gettype($gallery)
                );
            }

            // Populate view model with data we need in the view
            $gvm = new ViewModel();
            $gvm->setVariable('id', $gallery->getId())
                ->setVariable('title', $gallery->getTitle())
                ->setVariable('coverImagePath', $this->getGalleryCoverImagePath($gallery));

            $portfolio->addChild($gvm);
        }

        return $portfolio;
    }


    /**
     * Get gallery cover image path
     *
     * @param  DWI\PortfolioBundle\Entity\Gallery $gallery
     * @return false|string
     */
    private function getGalleryCoverImagePath($gallery)
    {
        if ($ci = $gallery->getCoverImage()) {
            return $ci->getImage()->getWebThumbPath();
        }

        return false;
    }
}
