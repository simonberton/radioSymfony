<?php


namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Tag;
use App\Entity\Programa;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * A post.
 *
 * @ORM\Entity(repositoryClass="App\Repository\PostRepository")
 * @Vich\Uploadable
 */
class Post
{
    CONST IMAGE_URL = '/images/posts/';
    CONST AUDIO_URL = '/audios/posts/';
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
     * @Gedmo\Slug(fields={"title"}, updatable=false)
     * @ORM\Column(length=128, unique=true)
     */
    private $slug;

    /**
     * @ORM\Column(type="text")
     */
    public $description;

    /**
     * @ORM\Column(type="text")
     */
    public $status = 'enabled';
    
   /**
     * @var \Doctrine\Common\Collections\Collection|Tags[]
     *
     * @ORM\ManyToMany(targetEntity="Tag", inversedBy="posts")
     * @ORM\JoinTable(
     *  name="post_tags",
     *  joinColumns={
     *      @ORM\JoinColumn(name="post_id", referencedColumnName="id")
     *  },
     *  inverseJoinColumns={
     *      @ORM\JoinColumn(name="tag_id", referencedColumnName="id")
     *  }
     * )
     */
    protected $tags;

    /**
     * @var \Doctrine\Common\Collections\Collection|Tags[]
     *
     * @ORM\ManyToMany(targetEntity="Programa", inversedBy="posts")
     * @ORM\JoinTable(
     *  name="post_programas",
     *  joinColumns={
     *      @ORM\JoinColumn(name="post_id", referencedColumnName="id")
     *  },
     *  inverseJoinColumns={
     *      @ORM\JoinColumn(name="programa_id", referencedColumnName="id")
     *  }
     * )
     */
    protected $programas;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $image;

    /**
     * @Vich\UploadableField(mapping="post_images", fileNameProperty="image")
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $audio;

    /**
     * @Vich\UploadableField(mapping="post_audios", fileNameProperty="audio")
     * @var File
     */
    private $audioFile;

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

    public function getSlug()
    {
        return $this->slug;
    }

    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * @param Tag $tag
     */
    public function addTag(Tag $tag)
    {
        if ($this->tags->contains($tag)) {
            return;
        }
        $this->tags->add($tag);
        $tag->addPost($this);
    }

    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param Programa $programa
     */
    public function addPrograma(Programa $programa)
    {
        if ($this->programas->contains($programa)) {
            return;
        }
        $this->programas->add($programa);
        $programa->addPost($this);
    }

    public function getProgramas()
    {
        return $this->programas;
    }

    public function getId()
    {
        return $this->id;
    }
    public function getTitle()
    {
        return $this->title;
    }
    public function setTitle($title)
    {
        $this->title = $title;
    }
    public function getDescription()
    {
        return $this->description;
    }
    public function setDescription($description)
    {
        $this->description = $description;
    }
    /**
     * @param UserGroup $userGroup
     */
    public function removeTag(Tag $tag)
    {
        if (!$this->tags->contains($tag)) {
            return;
        }
        $this->tags->removeElement($tag);
        $tag->removePost($this);
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

    public function setAudioFile(File $audio = null)
    {
        $this->audioFile = $audio;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($audio) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getAudioFile()
    {
        return $this->audioFile;
    }

    public function setAudio($audio)
    {
        $this->audio = $audio;
    }

    public function getAudio()
    {
        return $this->audio;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}