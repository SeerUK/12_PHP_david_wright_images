<?php

/**
 * David Wright Images
 *
 * @author  Elliot Wright <wright.elliot@gmail.com>
 * @since   2013
 * @package DWI
 */

namespace DWI\PortfolioBundle\View\Presenter\Gallery;

use DWI\CoreBundle\View\Model\ViewModel;
use DWI\CoreBundle\View\Presenter\AbstractPresenter;

/**
 * Gallery Presenter
 */
class GalleryPresenter extends AbstractPresenter
{
    /**
     * Prepare view
     *
     * @return ViewModel
     */
    public function prepareView()
    {
        $model = new ViewModel();

        return $model
            ->addChild($this->prepareControls(), 'controls')
            ->addChild($this->prepareGallery(), 'gallery');
    }


    /**
     * Prepare controls view model
     *
     * @return ViewModel
     */
    private function prepareControls()
    {
        $model   = new ViewModel();
        $gallery = $this->getVariable('gallery');

        return $model
            ->setVariable('galleryId', $gallery->getId())
            ->setVariable('views', $this->getVariable('views'))
            ->setVariable('isActive', $gallery->getIsActive());
    }


    /**
     * Prepare gallery view model
     *
     * @return ViewModel
     */
    private function prepareGallery()
    {
        $model   = new ViewModel();
        $gallery = $this->getVariable('gallery');

        return $model
            ->setVariable('id', $gallery->getId())
            ->setVariable('title', $gallery->getTitle())
            ->setVariable('subtitle', $gallery->getSubtitle())
            ->setVariable('description', $gallery->getDescription())
            ->setVariable('date', $gallery->getDate())
            ->setVariable('images', $this->getVariable('images'))
            ->setVariable('tags', $gallery->getTags());
    }
}
