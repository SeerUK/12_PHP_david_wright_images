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
            ->addChild($this->prepareForm(), 'form')
            ->addChild($this->prepareGallery(), 'gallery');
    }


    /**
     * Prepare form
     *
     * @return Symfony\Component\Form\FormView
     */
    public function prepareForm()
    {
        $fvm      = new ViewModel();
        $formView = $this->getVariable('form')
            ->createView();

        $fields = array();
        foreach ($formView->children as $child) {
            $fields[$child->vars['name']] = array(
                'name'  => $child->vars['full_name'],
                'value' => $child->vars['value'],
            );
        }

        $fvm->setVariable('fields', $fields);

        return $fvm;
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
