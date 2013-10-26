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
 * Tag
 *
 * @ORM\Table(name="Tag")
 * @ORM\Entity
 */
class Tag
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
     * @ORM\Column(name="name", type="string", length=30, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=250, nullable=false)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="lastModified", type="datetime", nullable=false)
     */
    private $lastmodified;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="DWI\PortfolioBundle\Entity\Gallery", mappedBy="tagid")
     */
    private $galleryId;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->galleryId = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Tag
     */
    public function setName($name)
    {
        $this->name = $name;

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
     * @return Tag
     */
    public function setDescription($description)
    {
        $this->description = $description;

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
     * @return Tag
     */
    public function setLastmodified($lastmodified)
    {
        $this->lastmodified = $lastmodified;

        return $this;
    }

    /**
     * Add galleryId
     *
     * @param \DWI\PortfolioBundle\Entity\Gallery $galleryId
     * @return Tag
     */
    public function addGalleryId(\DWI\PortfolioBundle\Entity\Gallery $galleryId)
    {
        $this->galleryId[] = $galleryId;

        return $this;
    }

    /**
     * Remove galleryId
     *
     * @param \DWI\PortfolioBundle\Entity\Gallery $galleryId
     */
    public function removeGalleryId(\DWI\PortfolioBundle\Entity\Gallery $galleryId)
    {
        $this->galleryId->removeElement($galleryId);
    }

    /**
     * Get galleryId
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGalleryId()
    {
        return $this->galleryId;
    }
}
