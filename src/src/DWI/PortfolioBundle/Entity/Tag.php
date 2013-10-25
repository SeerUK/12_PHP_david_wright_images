<?php

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
     * @ORM\Column(name="id", type="integer", nullable=false)
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
    private $galleryid;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->galleryid = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
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
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
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
     * Get lastmodified
     *
     * @return \DateTime 
     */
    public function getLastmodified()
    {
        return $this->lastmodified;
    }

    /**
     * Add galleryid
     *
     * @param \DWI\PortfolioBundle\Entity\Gallery $galleryid
     * @return Tag
     */
    public function addGalleryid(\DWI\PortfolioBundle\Entity\Gallery $galleryid)
    {
        $this->galleryid[] = $galleryid;
    
        return $this;
    }

    /**
     * Remove galleryid
     *
     * @param \DWI\PortfolioBundle\Entity\Gallery $galleryid
     */
    public function removeGalleryid(\DWI\PortfolioBundle\Entity\Gallery $galleryid)
    {
        $this->galleryid->removeElement($galleryid);
    }

    /**
     * Get galleryid
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGalleryid()
    {
        return $this->galleryid;
    }
}