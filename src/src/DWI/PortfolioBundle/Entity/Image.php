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
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Gallery Image Entity
 *
 * @ORM\Table(name="Image")
 * @ORM\Entity(repositoryClass="DWI\PortfolioBundle\Repository\ImageRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Image
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
     * @var integer
     *
     * @ORM\Column(name="displayOrder", type="integer", nullable=true)
     */
    private $displayOrder;

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
    private $gallery;

    /**
     * @var UploadedFile
     *
     * @Assert\NotBlank()
     * @Assert\File(maxSize="20971520")
     */
    private $file;

    /**
     * @var UploadedFile
     */
    private $temp;

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
     * @return Image
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
     * @param  string $path
     * @return Image
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get display order
     *
     * @return string
     */
    public function getDisplayOrder()
    {
        return $this->displayOrder;
    }

    /**
     * Set display order
     *
     * @param  integer $displayOrder
     * @return Image
     */
    public function setDisplayOrder($displayOrder)
    {
        $this->displayOrder = $displayOrder;

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
     * @return Image
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
     * Set gallery
     *
     * @param \DWI\PortfolioBundle\Entity\Gallery $gallery
     * @return Image
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
     * Gets absolute path for image
     *
     * @return string
     */
    public function getAbsolutePath()
    {
        return null === $this->path
            ? null
            : $this->getUploadRootDir() . '/' . $this->path;
    }

    /**
     * Gets absolute path for thumbnail cache image
     *
     * @return string
     */
    public function getAbsoluteThumbCachePath()
    {
        return null === $this->path
            ? null
            : $this->getThumbCacheRootDir() . '/' . $this->path;
    }

    /**
     * Gets absolute path for gallery cache image
     *
     * @return string
     */
    public function getAbsoluteGalleryCachePath()
    {
        return null === $this->path
            ? null
            : $this->getGalleryCacheRootDir() . '/' . $this->path;
    }

    /**
     * Gets web path for image
     *
     * @return string
     */
    public function getWebPath()
    {
        return null === $this->path
            ? null
            : $this->getUploadDir() . '/' . $this->path;
    }

    /**
     * Gets upload root directory
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
     * Gets web path
     *
     * @return string
     */
    protected function getUploadDir()
    {
        return 'bundles/dwiportfolio/albums/' . $this->getGallery()->getId();
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
     * Gets file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;

        // Check for an old image
        if (isset($this->path)) {
            $this->temp = $this->path;
            $this->path = null;
        } else {
            $this->path = 'initial';
        }
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->getFile()) {
            $filename = sha1(uniqid(mt_rand(), true));
            $this->path = $filename.'.'.$this->getFile()->guessExtension();
        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (null === $this->getFile()) {
            return;
        }

        $this->getFile()->move($this->getUploadRootDir(), $this->path);

        // Check for an old image
        if (isset($this->temp)) {
            // Delete the old image
            unlink($this->getUploadRootDir().'/'.$this->temp);

            // Clear the temp image path
            $this->temp = null;
        }

        $this->file = null;
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        $fs      = new Filesystem();
        $full    = $this->getAbsolutePath();             // Original file
        $thumb   = $this->getAbsoluteThumbCachePath();   // Imagine cached thumbnail
        $gallery = $this->getAbsoluteGalleryCachePath(); // Imagine cached gallery image

        if ($fs->exists($full)) {
            $fs->exists($full);
        }

        if ($fs->exists($thumb)) {
            $fs->exists($thumb);
        }

        if ($fs->exists($gallery)) {
            $fs->exists($gallery);
        }
    }
}
