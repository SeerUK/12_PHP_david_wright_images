<?php

/**
 * David Wright Images
 *
 * @author  Elliot Wright <wright.elliot@gmail.com>
 * @since   2013
 * @package DWI
 */

namespace DWI\PortfolioBundle\View\Presenter\Portfolio;

use DWI\CoreBundle\Exception\InvalidDataTypeException;
use DWI\CoreBundle\View\Model\ViewModel;
use DWI\CoreBundle\View\Presenter\AbstractPresenter;
use DWI\PortfolioBundle\Entity\Gallery;

/**
 * Portfolio Presenter
 */
class PortfolioPresenter extends AbstractPresenter
{
    /**
     * Prepare view model
     *
     * @return ViewModel
     */
    public function prepareView()
    {
        $model = new ViewModel();
        $model
            ->addChild($this->prepareControls(), 'controls')
            ->addChild($this->prepareGalleries(), 'portfolio');

        return $model;
    }


    /**
     * Prepare portfolio controls view models
     *
     * @return ViewModel
     */
    private function prepareControls()
    {
        $model = new ViewModel();
        $model->setVariable('views', $this->getVariable('views'));

        return $model;
    }


    /**
     * Prepare gallery view models
     *
     * @return ViewModel
     */
    private function prepareGalleries()
    {
        $portfolio = new ViewModel();

        foreach ($this->getVariable('galleries') as $gallery) {
            if ( ! $gallery instanceof Gallery) {
                throw new InvalidDataTypeException(
                    __METHOD__ .
                    ' expected an instance of DWI\PortfolioBundle\Entity\Gallery. Received ' .
                    gettype($gallery)
                );
            }

            // Populate view model with data we need in the view
            $gvm = new ViewModel();
            $gvm->setVariable('id', $gallery->getId())
                ->setVariable('title', $gallery->getTitle())
                ->setVariable('coverImagePath', $this->getGalleryCoverImagePath($gallery))
                ->setVariable('isActive', $gallery->getIsActive());

            $portfolio->addChild($gvm, 'galleries', true);
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
            return $ci->getImage()->getWebPath();
        }

        return false;
    }
}
