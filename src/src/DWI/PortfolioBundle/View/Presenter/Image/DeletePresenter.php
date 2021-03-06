<?php

/**
 * David Wright Images
 *
 * @author  Elliot Wright <wright.elliot@gmail.com>
 * @since   2013
 * @package DWI
 */

namespace DWI\PortfolioBundle\View\Presenter\Image;

use DWI\CoreBundle\View\Model\ViewModel;
use DWI\CoreBundle\View\Presenter\AbstractPresenter;

/**
 * Gallery Presenter
 */
class DeletePresenter extends AbstractPresenter
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
            ->addChild($this->prepareImage(), 'image')
            ->addChild($this->prepareGallery(), 'gallery');
    }


    /**
     * Prepare image view model
     *
     * @return ViewModel
     */
    private function prepareImage()
    {
        $ivm   = new ViewModel();
        $image = $this->getVariable('image');

        return $ivm
            ->setVariable('thumbnail', $image->getWebPath());
    }


    /**
     * Prepare gallery view model
     *
     * @return ViewModel
     */
    private function prepareGallery()
    {
        $gvm     = new ViewModel();
        $gallery = $this->getVariable('image')->getGallery();

        return $gvm
            ->setVariable('title', $gallery->getTitle());
    }
}
