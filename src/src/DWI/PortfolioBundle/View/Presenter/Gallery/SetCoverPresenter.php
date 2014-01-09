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
class SetCoverPresenter extends AbstractPresenter
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
            ->addChild($this->prepareGallery(), 'gallery')
            ->addChild($this->prepareImage(), 'image');
    }


    /**
     * Prepare gallery view model
     *
     * @return ViewModel
     */
    public function prepareGallery()
    {
        $model   = new ViewModel();
        $gallery = $this->getVariable('gallery');

        return $model
            ->setVariable('title', $gallery->getTitle());
    }


    /**
     * Prepare image view model
     *
     * @return ViewModel
     */
    public function prepareImage()
    {
        $model = new ViewModel();
        $image = $this->getVariable('image');

        return $model
            ->setVariable('thumbnail', $image->getWebPath());
    }
}
