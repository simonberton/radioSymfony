<?php


namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


/**
 * A slide.
 *
 * @ORM\Entity(repositoryClass="App\Repository\SlideRepository")
 * @Vich\Uploadable
 */
class Slide
{
    CONST IMAGE_URL = '/images/slides/';
    /**
     * @var int The id of this post.
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string The title of this post.
     *
     * @ORM\Column(type="string")
     */
    public $title;

    /**
     * @ORM\Column(type="text")
     */
    public $description;

    /**
     * @ORM\Column(type="text")
     */
    public $status = 'enabled';

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $image;

    /**
     * @Vich\UploadableField(mapping="slide_images", fileNameProperty="image")
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * Default constructor, initializes collections
     */
    public function __construct()
    {
        $this->tags = new ArrayCollection();
        //$this->updatedAt = new \DateTime('now');
    }

    public function getId()
    {
        return $this->id;
    }

    public function __toString()
    {
        return $this->title;
    }

    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($image) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getImageFile()
    {
        return $this->imageFile;
    }

    public function setImage($image)
    {
        $this->image = $image;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
    public function getTitle()
    {
        return $this->title;
    }
    public function getDescription()
    {
        return $this->description;
    }
}