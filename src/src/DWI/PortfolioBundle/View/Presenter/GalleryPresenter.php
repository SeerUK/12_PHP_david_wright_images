<?php

/**
 * David Wright Images
 *
 * @author  Elliot Wright <wright.elliot@gmail.com>
 * @since   2013
 * @package DWI
 */

namespace DWI\PortfolioBundle\View\Presenter;

use DWI\CoreBundle\View\Model\ViewModel;
use DWI\CoreBundle\View\Presenter\AbstractPresenter;

/**
 * Gallery Presenter
 */
class GalleryPresenter extends AbstractPresenter
{
    public function prepareView()
    {
        $model = new ViewModel();

        return $model
            ->addChild($this->prepareControls(), 'controls')
            ->addChild($this->prepareGallery(), 'gallery');
    }


    /**
     * Prepare controls view model
     */
    public function prepareControls()
    {
        $cvm = new ViewModel();

        return $cvm
            ->setVariable('views', $this->getVariable('views'));
    }


    /**
     * Prepare gallery view model
     *
     * @return ViewModel
     */
    public function prepareGallery()
    {
        $gvm     = new ViewModel();
        $gallery = $this->getVariable('gallery');

        return $gvm
            ->setVariable('title', $gallery->getTitle())
            ->setVariable('subtitle', $gallery->getSubtitle())
            ->setVariable('description', $gallery->getDescription())
            ->setVariable('date', $gallery->getDate())
            ->setVariable('images', $gallery->getImages());
    }
}
