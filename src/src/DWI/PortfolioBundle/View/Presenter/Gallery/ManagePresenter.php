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
            ->addChild($this->prepareGallery(), 'gallery')
            ->addChild($this->prepareViews(), 'views');
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

        $images = array();
        foreach ($this->getVariable('images') as $image) {
            $images[] = array(
                'id'           => $image->getId(),
                'description'  => $image->getDescription(),
                'webPath'      => $image->getWebPath(),
                'displayOrder' => $image->getDisplayOrder(),
                'lastModified' => $image->getLastModified(),
            );
        }

        return $model
            ->setVariable('id', $gallery->getId())
            ->setVariable('title', $gallery->getTitle())
            ->setVariable('isActive', $gallery->getIsActive())
            ->setVariable('coverImage', $gallery->getCoverImage())
            ->setVariable('tags', $gallery->getTags())
            ->setVariable('images', $images);
    }


    /**
     * Prepare view view model
     *
     * @return ViewModel
     */
    private function prepareViews()
    {
        $model = new ViewModel();

        $views = array();
        foreach ($this->getVariable('datedViews') as $view) {
            $views[$view['date']] = (int) $view['views'];
        }

        $dates = array();
        for ($i = 0; $i < 30; $i++) {
            $timestamp = strtotime('-'. $i .' days');
            $date      = date('Y-m-d', $timestamp);

            $dates[$i][] = $timestamp * 1000;
            $dates[$i][] = isset($views[$date])
                ? $views[$date]
                : 0;
        }

        $dates = array_reverse($dates);

        return $model
            ->setVariable('chartViews', $dates)
            ->setVariable('total', $this->getVariable('totalViews'));
    }
}
