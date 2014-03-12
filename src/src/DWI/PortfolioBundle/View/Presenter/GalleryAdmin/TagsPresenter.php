<?php

/**
 * David Wright Images
 *
 * @author  Elliot Wright <wright.elliot@gmail.com>
 * @since   2013
 * @package DWI
 */

namespace DWI\PortfolioBundle\View\Presenter\GalleryAdmin;

use DWI\CoreBundle\Exception\InvalidDataTypeException;
use DWI\CoreBundle\Tools\Pagination\Paginator;
use DWI\CoreBundle\View\Model\ViewModel;
use DWI\CoreBundle\View\Presenter\AbstractPresenter;
use DWI\PortfolioBundle\Entity\Gallery;
use DWI\PortfolioBundle\Repository\GalleryRepository;

/**
 * Galleries Presenter
 */
class TagsPresenter extends AbstractPresenter
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
            ->setVariable('gallery', $this->prepareGallery())
            ->setVariable('galleryTags', $this->prepareGalleryTags())
            ->setVariable('tags', $this->prepareTags());
    }


    /**
     * Prepare gallery
     *
     * @return Gallery
     */
    private function prepareGallery()
    {
        return $this->getVariable('gallery');
    }


    /**
     * Prepare gallery tags
     *
     * @return Tag[]
     */
    private function prepareGalleryTags()
    {
        return $this->getVariable('galleryTags');
    }


    /**
     * Prepare tags
     *
     * @return Tag[]
     */
    private function prepareTags()
    {
        return array_udiff($this->getVariable('tags'), $this->getVariable('galleryTags'), function($a, $b) {
            return $a->getId() - $b->getId();
        });
    }
}
