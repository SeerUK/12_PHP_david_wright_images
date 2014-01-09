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
class DeleteImagePresenter extends AbstractPresenter
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
            ->addChild($this->prepareImage(), 'image');
    }


    /**
     * Prepare gallery view model
     *
     * @return ViewModel
     */
    public function prepareImage()
    {
        $gvm   = new ViewModel();
        $image = $this->getVariable('image');

        return $gvm
            ->setVariable('thumbnail', $image->getWebPath());
    }
}
