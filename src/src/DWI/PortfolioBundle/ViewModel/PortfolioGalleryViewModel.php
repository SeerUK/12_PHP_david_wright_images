<?php

/**
 * David Wright Images
 *
 * @author  Elliot Wright <wright.elliot@gmail.com>
 * @since   2013
 * @package DWI
 */

namespace DWI\PortfolioBundle\ViewModel;

use DWI\CoreBundle\ViewModel\AbstractViewModel;
use DWI\PortfolioBundle\Exception\InvalidDataTypeException;

/**
 * Portfolio View Model
 */
class PortfolioGalleryViewModel extends AbstractViewModel
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $coverImagePath;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets id
     *
     * @param integer $id
     * @return PortfolioGalleryViewModel
     */
    public function setId($id)
    {
        if (!filter_var($id, FILTER_VALIDATE_INT)) {
            throw new InvalidDataTypeException('$id is expected to be an integer.');
        }

        $this->id = $id;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Sets title
     *
     * @param string $title
     * @return PortfolioGalleryViewModel
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get cover image path
     *
     * @return string
     */
    public function getCoverImagePath()
    {
        return $this->coverImagePath;
    }

    /**
     * Set cover image path
     *
     * @param string $coverImagePath
     */
    public function setCoverImagePath($coverImagePath)
    {
        $this->coverImagePath = $coverImagePath;

        return $this;
    }
}