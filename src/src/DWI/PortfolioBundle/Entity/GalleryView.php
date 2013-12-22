<?php

/**
 * David Wright Images
 *
 * @author  Elliot Wright <wright.elliot@gmail.com>
 * @since   2013
 * @package DWI
 */

namespace DWI\PortfolioBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use DWI\PortfolioBundle\Entity\Gallery;

/**
 * Gallery View
 *
 * @ORM\Table(name="GalleryView")
 * @ORM\Entity
 */
class GalleryView
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var DWI\PortfolioBundle\Entity\Gallery
     *
     * @ORM\OneToOne(targetEntity="DWI\PortfolioBundle\Entity\Gallery", inversedBy="views")
     * @JoinColumn(name="galleryId", referencedColumnName="id")
     */
    private $gallery;

    /**
     * @var integer
     *
     * @ORM\Column(name="views", type="integer")
     */
    private $views;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="lastModified", type="datetime", nullable=false)
     */
    private $lastmodified;

    /**
     * Set gallery
     *
     * @param Gallery $gallery
     * @return GalleryView
     */
    public function setGallery(Gallery $gallery)
    {
        $this->gallery = $gallery;

        return $this;
    }

    /**
     * Get gallery
     *
     * @return Gallery
     */
    public function getGallery()
    {
        return $this->gallery;
    }

    /**
     * Set views
     *
     * @param  integer $views
     * @return GalleryView
     */
    public function setViews($views)
    {
        $this->views = $views;

        return $this;
    }

    /**
     * Get views
     *
     * @return integer
     */
    public function getViews()
    {
        return $this->views;
    }
}
