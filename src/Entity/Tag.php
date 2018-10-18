<?php


namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Post;

/**
 * A tag.
 *
 * @ORM\Entity
 */
class Tag
{
    /**
     * @var int The id of this tag.
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string The title of this tag.
     *
     * @ORM\Column(type="string")
     */
    public $title;

    /**
     * @ORM\Column(type="text")
     */
    public $description;

    /**
     * @var \Doctrine\Common\Collections\Collection|User[]
     *
     * @ORM\ManyToMany(targetEntity="Post", mappedBy="tags")
     */
    protected $posts;
    /**
     * Default constructor, initializes collections
     */
    public function __construct()
    {
        $this->posts = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @param Post $post
     */
    public function addPost(Post $post)
    {
        if ($this->posts->contains($post)) {
            return;
        }
        $this->posts->add($post);
        $post->addTag($this);
    }

    /**
     * @param Post $post
     */
    public function removePost(Post $post)
    {
        if (!$this->posts->contains($post)) {
            return;
        }
        $this->posts->removeElement($post);
        $post->removeTag($this);
    }

    public function getPosts()
    {
        return $this->posts;
    }

    public function __toString()
    {
        return $this->title;
    }
}