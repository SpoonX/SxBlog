<?php

namespace SxBlog\Entity;

use \DateTime;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Category
 *
 * @ORM\Table(
 *      name="categories",
 *      uniqueConstraints={
 *          @ORM\UniqueConstraint(name="name_idx", columns={"name"}),
 *          @ORM\UniqueConstraint(name="slug_idx", columns={"slug"})
 *      },
 *      indexes={
 *          @ORM\Index(name="creationDate_idx", columns={"creationDate"})
 *      }
 * )
 * @ORM\Entity(repositoryClass="SxBlog\Repository\CategoryRepository")
 */
class Category
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
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    protected $slug;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Post", mappedBy="categories")
     */
    protected $posts;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->posts        = new ArrayCollection();
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
     * Set name
     *
     * @param string $name
     *
     * @return Category
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
     * Set slug
     *
     * @param string $slug
     *
     * @return Category
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
     * @return \Doctrine\Common\Collections\ArrayCollection|\Doctrine\Common\Collections\Collection
     */
    public function getPosts()
    {
        return $this->posts;
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
        $post->addCategorie($this);
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
        $post->removeCategorie($this);
    }

}
