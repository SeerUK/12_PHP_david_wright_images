<?php

namespace DWI\PortfolioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Gallery
 *
 * @ORM\Table(name="Gallery")
 * @ORM\Entity
 */
class Gallery
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
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=5000, nullable=false)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=false)
     */
    private $date;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="lastModified", type="datetime", nullable=false)
     */
    private $lastmodified;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="DWI\PortfolioBundle\Entity\Tag", inversedBy="galleryid")
     * @ORM\JoinTable(name="gallerytagmap",
     *   joinColumns={
     *     @ORM\JoinColumn(name="galleryId", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="tagId", referencedColumnName="id")
     *   }
     * )
     */
    private $tagid;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tagid = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Gallery
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
     * @return Gallery
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
     * Set date
     *
     * @param \DateTime $date
     * @return Gallery
     */
    public function setDate($date)
    {
        $this->date = $date;
    
        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set lastmodified
     *
     * @param \DateTime $lastmodified
     * @return Gallery
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
     * Add tagid
     *
     * @param \DWI\PortfolioBundle\Entity\Tag $tagid
     * @return Gallery
     */
    public function addTagid(\DWI\PortfolioBundle\Entity\Tag $tagid)
    {
        $this->tagid[] = $tagid;
    
        return $this;
    }

    /**
     * Remove tagid
     *
     * @param \DWI\PortfolioBundle\Entity\Tag $tagid
     */
    public function removeTagid(\DWI\PortfolioBundle\Entity\Tag $tagid)
    {
        $this->tagid->removeElement($tagid);
    }

    /**
     * Get tagid
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTagid()
    {
        return $this->tagid;
    }
}