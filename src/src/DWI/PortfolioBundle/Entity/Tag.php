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
 * Tag Entity
 *
 * @ORM\Table(name="Tag")
 * @ORM\Entity(repositoryClass="DWI\PortfolioBundle\Repository\TagRepository")
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
     * @var boolean
     *
     * @ORM\Column(name="isPrimary", type="boolean", nullable=false)
     */
    private $isPrimary;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="lastModified", type="datetime", nullable=false)
     */
    private $lastmodified;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="DWI\PortfolioBundle\Entity\Gallery", mappedBy="tags")
     */
    private $galleries;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->galleries = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @param  string $description
     * @return Tag
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get isPrimary
     *
     * @return boolean
     */
    public function getIsPrimary()
    {
        return $this->isPrimary;
    }

    /**
     * Set isPrimary
     *
     * @param  boolean $isPrimary
     * @return Tag
     */
    public function setIsPrimary($isPrimary)
    {
        $this->isPrimary = $isPrimary;

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
     * @param  \DateTime $lastmodified
     * @return Tag
     */
    public function setLastmodified($lastmodified)
    {
        $this->lastmodified = $lastmodified;

        return $this;
    }

    /**
     * Add gallery
     *
     * @param  \DWI\PortfolioBundle\Entity\Gallery $gallery
     * @return Tag
     */
    public function addGallery(\DWI\PortfolioBundle\Entity\Gallery $gallery)
    {
        $this->galleries[] = $gallery;

        return $this;
    }

    /**
     * Remove gallery
     *
     * @param \DWI\PortfolioBundle\Entity\Gallery $gallery
     */
    public function removeGallery(\DWI\PortfolioBundle\Entity\Gallery $gallery)
    {
        $this->galleries->removeElement($gallery);
    }

    /**
     * Get galleries
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGalleries()
    {
        return $this->galleries;
    }
}
