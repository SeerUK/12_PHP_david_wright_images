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
use DWI\CoreBundle\Tools\Pagination\Paginator;
use DWI\CoreBundle\View\Model\ViewModel;
use DWI\CoreBundle\View\Presenter\AbstractPresenter;
use DWI\PortfolioBundle\Entity\Gallery;
use DWI\PortfolioBundle\Entity\Tag;
use DWI\PortfolioBundle\Repository\GalleryRepository;

/**
 * Portfolio View Presenter
 */
class ViewTagPresenter extends AbstractPresenter
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
            ->addChild($this->preparePagination(), 'pagination')
            ->addChild($this->prepareGalleries(), 'portfolio')
            ->addChild($this->prepareTag(), 'tag')
            ->setVariable('tags', $this->getVariable('tags'));

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
        $tag   = $this->getVariable('tag');

        $model->setVariable('views_type', ucfirst($tag->getName()) . ' gallery views');
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
     * Prepare Tag view model
     *
     * @return ViewModel
     */
    private function prepareTag()
    {
        $model = new ViewModel();
        $tag   = $this->getVariable('tag');

        return $model
            ->setVariable('id', $tag->getId())
            ->setVariable('name', $tag->getName());
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
