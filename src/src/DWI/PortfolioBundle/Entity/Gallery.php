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
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

/**
 * Gallery Entity
 *
 * @ORM\Table(name="Gallery")
 * @ORM\Entity(repositoryClass="DWI\PortfolioBundle\Repository\GalleryRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Gallery
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
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="subtitle", type="string", length=255, nullable=false)
     */
    private $subtitle;

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
     * @var boolean
     *
     * @ORM\Column(name="isActive", type="boolean", nullable=false)
     */
    private $isActive;

    /**
     * @var DWI\PortfolioBundle\Entity\GalleryView
     *
     * @ORM\OneToOne(targetEntity="DWI\PortfolioBundle\Entity\GalleryView", mappedBy="gallery")
     */
    private $views;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="lastModified", type="datetime", nullable=false)
     */
    private $lastmodified;

    /**
     * @var Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="DWI\PortfolioBundle\Entity\Image", mappedBy="gallery")
     */
    protected $images;

    /**
     * @var DWI\PortfolioBundle\Entity\GalleryCoverImage
     *
     * @ORM\OneToOne(targetEntity="DWI\PortfolioBundle\Entity\CoverImage", mappedBy="gallery", cascade={"persist", "merge"})
     */
    protected $coverImage;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="DWI\PortfolioBundle\Entity\Tag", inversedBy="galleries")
     * @ORM\JoinTable(name="GalleryTag",
     *   joinColumns={
     *     @ORM\JoinColumn(name="galleryId", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="tagId", referencedColumnName="id")
     *   }
     * )
     */
    private $tags;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->tags   = new ArrayCollection();
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Gallery
     */
    public function setTitle($title)
    {
        $this->title = $title;

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
     * Set subtitle
     *
     * @param string $subtitle
     * @return Gallery
     */
    public function setSubtitle($subtitle)
    {
        $this->subtitle = $subtitle;

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
     * Set isActive
     *
     * @param  boolean $isActive
     * @return Gallery
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set views
     *
     * @param integer $views
     * @return Gallery
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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Add images
     *
     * @param \DWI\PortfolioBundle\Entity\Image $images
     * @return Gallery
     */
    public function addImage(\DWI\PortfolioBundle\Entity\Image $images)
    {
        $this->images[] = $images;

        return $this;
    }

    /**
     * Remove images
     *
     * @param \DWI\PortfolioBundle\Entity\Image $images
     */
    public function removeImage(\DWI\PortfolioBundle\Entity\Image $images)
    {
        $this->images->removeElement($images);
    }

    /**
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Get cover image
     *
     * @return \DWI\PortfolioBundle\Entity\CoverImage
     */
    public function getCoverImage()
    {
        return $this->coverImage;
    }

    /**
     * Set cover image ...
     *
     * @param \DWI\PortfolioBundle\Entity\CoverImage $coverImage
     * @return Gallery
     */
    public function setCoverImage(\DWI\PortfolioBundle\Entity\CoverImage $coverImage)
    {
        $this->coverImage = $coverImage;

        return $this;
    }

    /**
     * Add tag
     *
     * @param \DWI\PortfolioBundle\Entity\Tag $tag
     * @return Gallery
     */
    public function addTag(\DWI\PortfolioBundle\Entity\Tag $tag)
    {
        $this->tags[] = $tag;

        return $this;
    }

    /**
     * Remove tag
     *
     * @param \DWI\PortfolioBundle\Entity\Tag $tag
     */
    public function removeTag(\DWI\PortfolioBundle\Entity\Tag $tag)
    {
        $this->tags->removeElement($tag);
    }

    /**
     * Get tags
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Get upload root directory
     *
     * @return string
     */
    protected function getUploadRootDir()
    {
        return __DIR__ . '/../../../../web/' . $this->getUploadDir();
    }

    /**
     * Gets thumb cache root directory
     *
     * @return string
     */
    protected function getThumbCacheRootDir()
    {
        return __DIR__ . '/../../../../web/' . $this->getThumbCacheDir();
    }

    /**
     * Gets gallery image cache root directory
     *
     * @return string
     */
    protected function getGalleryCacheRootDir()
    {
        return __DIR__ . '/../../../../web/' . $this->getGalleryCacheDir();
    }

    /**
     * Gets admin image cache root directory
     *
     * @return string
     */
    protected function getAdminImageCacheRootDir()
    {
        return __DIR__ . '/../../../../web/' . $this->getAdminImageCacheDir();
    }

    /**
     * Gets admin gallery image cache root directory
     *
     * @return string
     */
    protected function getAdminGalleryCacheRootDir()
    {
        return __DIR__ . '/../../../../web/' . $this->getAdminGalleryCacheDir();
    }

    /**
     * Get web path
     *
     * @return string
     */
    protected function getUploadDir()
    {
        return 'bundles/dwiportfolio/albums/' . $this->getId();
    }

    /**
     * Gets Imagine thumb cache path
     *
     * @return string
     */
    protected function getThumbCacheDir()
    {
        return 'media/cache/gallery_thumb/' . $this->getUploadDir();
    }

    /**
     * Gets Imagine gallery image cache path
     *
     * @return string
     */
    protected function getGalleryCacheDir()
    {
        return 'media/cache/gallery_image/' . $this->getUploadDir();
    }

    /**
     * Gets Imagine admin image cache path
     *
     * @return string
     */
    protected function getAdminImageCacheDir()
    {
        return 'media/cache/admin_image_thumb/' . $this->getUploadDir();
    }

    /**
     * Gets Imagine admin gallery image cache path
     *
     * @return string
     */
    protected function getAdminGalleryCacheDir()
    {
        return 'media/cache/admin_gallery_thumb/' . $this->getUploadDir();
    }

    /**
     * @ORM\PreRemove()
     */
    public function removeFiles()
    {
        $fs         = new Filesystem();
        $full       = $this->getUploadRootDir();
        $thumb      = $this->getThumbCacheRootDir();
        $gallery    = $this->getGalleryCacheRootDir();
        $admImage   = $this->getAdminImageCacheRootDir();
        $admGallery = $this->getAdminGalleryCacheRootDir();

        if ($fs->exists($full)) {
            $fs->remove($full);
        }

        if ($fs->exists($thumb)) {
            $fs->remove($thumb);
        }

        if ($fs->exists($gallery)) {
            $fs->remove($gallery);
        }

        if ($fs->exists($admImage)) {
            $fs->remove($admImage);
        }

        if ($fs->exists($admGallery)) {
            $fs->remove($admGallery);
        }
    }
}
