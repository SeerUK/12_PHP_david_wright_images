<?php

/**
 * David Wright Images
 *
 * @author  Elliot Wright <wright.elliot@gmail.com>
 * @since   2013
 * @package DWI
 */

namespace DWI\PortfolioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GalleryImage
 *
 * @ORM\Table(name="GalleryImage")
 * @ORM\Entity
 */
class GalleryImage
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
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=250, nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=250, nullable=false)
     */
    private $path;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="lastModified", type="datetime", nullable=false)
     */
    private $lastmodified;

    /**
     * @var \DWI\PortfolioBundle\Entity\Gallery
     *
     * @ORM\ManyToOne(targetEntity="DWI\PortfolioBundle\Entity\Gallery", inversedBy="images")
     * @ORM\JoinColumn(name="galleryId", referencedColumnName="id")
     */
    private $galleryId;

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
     * @return GalleryImage
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set path
     *
     * @param string $path
     * @return GalleryImage
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get lastmodified
     *
     * @return \DateTime
     */
    public function getLastmodified()
    {
        return $this->lastmodified;
    }

    /**
     * Set lastmodified
     *
     * @param \DateTime $lastmodified
     * @return GalleryImage
     */
    public function setLastmodified($lastmodified)
    {
        $this->lastmodified = $lastmodified;

        return $this;
    }

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
     * Set galleryId
     *
     * @param \DWI\PortfolioBundle\Entity\Gallery $galleryId
     * @return GalleryImage
     */
    public function setGalleryId(\DWI\PortfolioBundle\Entity\Gallery $galleryId = null)
    {
        $this->galleryId = $galleryId;

        return $this;
    }

    /**
     * Get galleryId
     *
     * @return \DWI\PortfolioBundle\Entity\Gallery
     */
    public function getGalleryId()
    {
        return $this->galleryId;
    }
}
