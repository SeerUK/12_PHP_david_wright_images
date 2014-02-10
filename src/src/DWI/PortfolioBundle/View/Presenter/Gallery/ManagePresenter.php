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
 * Manage Presenter
 */
class ManagePresenter extends AbstractPresenter
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
            ->addChild($this->prepareGallery(), 'gallery');
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
        $images  = array();

        foreach ($gallery->getImages() as $image) {
            $images[] = array(
                'id'           => $image->getId(),
                'description'  => $image->getDescription(),
                'webPath'      => $image->getWebPath(),
                'lastModified' => $image->getLastModified(),
            );
        }

        return $model
            ->setVariable('id', $gallery->getId())
            ->setVariable('title', $gallery->getTitle())
            ->setVariable('images', $images);
    }
}
