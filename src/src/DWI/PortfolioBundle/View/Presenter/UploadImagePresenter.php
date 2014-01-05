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
 * Upload Image Presenter
 */
class UploadImagePresenter extends AbstractPresenter
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
            ->setVariable('form', $this->prepareForm())
            ->addChild($this->prepareGallery(), 'gallery');
    }


    /**
     * Prepare form
     *
     * @return Symfony\Component\Form\FormView
     */
    public function prepareForm()
    {
        return $this->getVariable('form')
            ->createView();
    }


    /**
     * Prepare gallery
     *
     * @return ViewModel
     */
    public function prepareGallery()
    {
        $gvm     = new ViewModel();
        $gallery = $this->getVariable('gallery');

        return $gvm
            ->setVariable('id', $gallery->getId())
            ->setVariable('title', $gallery->getTitle());
    }
}
