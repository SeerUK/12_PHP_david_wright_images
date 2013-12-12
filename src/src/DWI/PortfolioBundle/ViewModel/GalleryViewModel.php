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

/**
 * Gallery view model
 */
class GalleryViewModel extends AbstractViewModel
{
    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $subtitle;

    /**
     * @var string
     */
    private $description;

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var \Doctrine\ORM\PersistenCollection
     */
    private $images;

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
     * Set title
     *
     * @param string $title
     * @return GalleryViewModel
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get subtitle
     *
     * @return string
     */
    public function getSubtitle()
    {
        return $this->subtitle;
    }

    /**
     * Set subtitle
     *
     * @param string $subtitle
     * @return GalleryViewModel
     */
    public function setSubtitle($subtitle)
    {
        $this->subtitle = $subtitle;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return GalleryViewModel
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get date
     *
     * @return string
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return GalleryViewModel
     */
    public function setDate(\DateTime $date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get images
     *
     * @return \Doctrine\ORM\PersistenCollection
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Set images
     *
     * @param \Doctrine\ORM\PersistentCollection $images
     * @return GalleryViewModel
     */
    public function setImages(\Doctrine\ORM\PersistentCollection $images)
    {
        $this->images = $images;

        return $this;
    }
}
