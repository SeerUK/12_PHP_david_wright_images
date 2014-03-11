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
            ->setVariable('tags', $this->prepareTags());
    }


    /**
     * Prepare tags
     *
     * @return Tag[]
     */
    private function prepareTags()
    {
        return $this->getVariable('tags');
    }
}
