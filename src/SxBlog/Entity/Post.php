<?php

namespace SxBlog\Entity;

use \DateTime;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use ZfcUserDoctrineORM\Entity\User as UserEntity;

/**
 * Post
 *
 * @ORM\Table(
 *      name                = "posts",
 *      uniqueConstraints   = {
 *          @ORM\UniqueConstraint(name="slug_idx", columns={"slug"})
 *      },
 *      indexes = {
 *          @ORM\Index(name="title_idx",        columns={"title"}),
 *          @ORM\Index(name="creationDate_idx", columns={"creationDate"}),
 *      }
 * )
 * @ORM\Entity(repositoryClass="SxBlog\Repository\PostRepository")
 */
class Post
{

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    protected $creationDate;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    protected $title;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     */
    protected $body;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    protected $slug;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Category", inversedBy="posts")
     * @ORM\JoinTable(
     *  name="post_category",
     *  joinColumns={
     *      @ORM\JoinColumn(name="post_id", referencedColumnName="id")
     *  },
     *  inverseJoinColumns={
     *      @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     *  }
     * )
     */
    protected $categories;

    /**
     * @var \ZfcUserDoctrineORM\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="ZfcUserDoctrineORM\Entity\User")
     * @ORM\JoinColumn(name="author_id", referencedColumnName="user_id", unique=false, nullable=false)
     */
    protected $author;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->categories   = new ArrayCollection();
        $this->creationDate = new DateTime;
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
     * Get creationDate
     *
     * @return \DateTime
     */
    public function getCreationDate()
    {
        return clone $this->creationDate;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Post
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
     * Set body
     *
     * @param string $body
     * @return Post
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get body
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Post
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }







    /**
     * @param \SxBlog\Entity\Category $category
     */
    public function addCategorie(Category $category)
    {
        if ($this->categories->contains($category)) {
            return;
        }

        $this->categories->add($category);
        $category->addPost($this);
    }

    /**
     * @param \SxBlog\Entity\Category $category
     */
    public function removeCategorie(Category $category)
    {
        if (!$this->categories->contains($category)) {
            return;
        }

        $this->categories->removeElement($category);
        $category->removePost($this);
    }







    /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Set author
     *
     * @param \ZfcUserDoctrineORM\Entity\User $author
     * @return Post
     */
    public function setAuthor(UserEntity $author = null)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return \ZfcUserDoctrineORM\Entity\User
     */
    public function getAuthor()
    {
        return $this->author;
    }

}
