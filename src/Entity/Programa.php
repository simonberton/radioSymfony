<?php


namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Post;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * A programa.
 *
 * @ORM\Entity(repositoryClass="App\Repository\ProgramaRepository")
 * @Vich\Uploadable
 */
class Programa
{
    CONST IMAGE_URL = '/images/programas/';
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
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @var \Doctrine\Common\Collections\Collection|User[]
     *
     * @ORM\ManyToMany(targetEntity="Post", mappedBy="programas")
     */
    protected $posts;

    /**
     * Default constructor, initializes collections
     */
    public function __construct()
    {
        $this->tags = new ArrayCollection();
        $this->posts = new ArrayCollection();
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
     * @param UserGroup $userGroup
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

    public function setBajada($texto)
    {
        $this->bajada = $texto;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function getPosts(){
        return $this->posts;
    }

    public function addPosts($post){
        $this->posts->add($post);
        return $this;
    }

    public function setUpdatedAt($date)
    {
        $this->updatedAt = new \DateTime('now');
        return $this;
    }
}