<?php

namespace DWI\PortfolioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CoverImage
 *
 * @ORM\Table(name="CoverImage")
 * @ORM\Entity
 */
class CoverImage
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="lastModified", type="datetime", nullable=false)
     */
    private $lastModified;

    /**
     * @var \DWI\PortfolioBundle\Entity\Gallery
     *
     * @ORM\OneToOne(targetEntity="DWI\PortfolioBundle\Entity\Gallery", inversedBy="coverImage")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="galleryId", referencedColumnName="id")
     * })
     */
    private $gallery;

    /**
     * @var \DWI\PortfolioBundle\Entity\Image
     *
     * @ORM\OneToOne(targetEntity="DWI\PortfolioBundle\Entity\Image")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="imageId", referencedColumnName="id")
     * })
     */
    private $image;

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
     * Set lastModified
     *
     * @param \DateTime $lastModified
     * @return CoverImage
     */
    public function setLastmodified($lastModified)
    {
        $this->lastModified = $lastModified;

        return $this;
    }

    /**
     * Get lastModified
     *
     * @return \DateTime
     */
    public function getLastmodified()
    {
        return $this->lastModified;
    }

    /**
     * Set gallery
     *
     * @param \DWI\PortfolioBundle\Entity\Gallery $gallery
     * @return CoverImage
     */
    public function setGallery(\DWI\PortfolioBundle\Entity\Gallery $gallery = null)
    {
        $this->gallery = $gallery;

        return $this;
    }

    /**
     * Get gallery
     *
     * @return \DWI\PortfolioBundle\Entity\Gallery
     */
    public function getGallery()
    {
        return $this->gallery;
    }

    /**
     * Set image
     *
     * @param \DWI\PortfolioBundle\Entity\Image $image
     * @return CoverImage
     */
    public function setImage(\DWI\PortfolioBundle\Entity\Image $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \DWI\PortfolioBundle\Entity\Image
     */
    public function getImage()
    {
        return $this->image;
    }
}