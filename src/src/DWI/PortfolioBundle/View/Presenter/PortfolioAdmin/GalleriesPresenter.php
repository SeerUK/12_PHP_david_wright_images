<?php

/**
 * David Wright Images
 *
 * @author  Elliot Wright <wright.elliot@gmail.com>
 * @since   2013
 * @package DWI
 */

namespace DWI\PortfolioBundle\View\Presenter\PortfolioAdmin;

use DWI\CoreBundle\Exception\InvalidDataTypeException;
use DWI\CoreBundle\Tools\Pagination\Paginator;
use DWI\CoreBundle\View\Model\ViewModel;
use DWI\CoreBundle\View\Presenter\AbstractPresenter;
use DWI\PortfolioBundle\Entity\Gallery;
use DWI\PortfolioBundle\Repository\GalleryRepository;

/**
 * Galleries Presenter
 */
class GalleriesPresenter extends AbstractPresenter
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
            ->addChild($this->preparePortfolio(), 'portfolio')
            ->addChild($this->preparePagination(), 'pagination')
            ->addChild($this->prepareViews(), 'views');
    }


    /**
     * Prepare portfolio view model, containing galleries
     *
     * @return ViewModel
     */
    private function preparePortfolio()
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
                ->setVariable('subtitle', $gallery->getSubTitle())
                ->setVariable('coverImagePath', $this->getGalleryCoverImagePath($gallery))
                ->setVariable('images', $gallery->getImages())
                ->setVariable('isActive', $gallery->getIsActive());

            $portfolio->addChild($gvm, 'galleries', true);
        }

        return $portfolio;
    }


    /**
     * Prepare pagination
     *
     * @return ViewModel
     */
    public function preparePagination()
    {
        $model        = new ViewModel();
        $page         = $this->getVariable('page');
        $galleryCount = $this->getVariable('galleryCount');

        $pages     = (int) ceil($galleryCount / GalleryRepository::PER_PAGE);
        $paginator = new Paginator($pages);


        $start = $paginator->calculateStart($page);
        $end   = $paginator->calculateEnd($page);

        $model
            ->setVariable('page', $page)
            ->setVariable('pages', $pages)
            ->setVariable('start', $start)
            ->setVariable('end', $end);

        return $model;
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
