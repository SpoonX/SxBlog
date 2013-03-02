<?php

namespace SxBlog\Entity;

use Doctrine\ORM\Mapping as ORM;
use SxBlog\Entity\Post as PostEntity;
use SxBlog\Entity\Category as CategoryEntity;

/**
 * @ORM\Entity
 * @ORM\Table(name="post_category", uniqueConstraints={
 *     @ORM\UniqueConstraint(name="posts_categories_idx", columns={"post_id", "category_id"})
 * })
 */
class PostsCategories
{

    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var \SxBlog\Entity\Category
     *
     * @ORM\ManyToOne(targetEntity="SxBlog\Entity\Post")
     * @ORM\JoinColumn(onDelete="cascade")
     */
    protected $category;

    /**
     * @var \SxBlog\Entity\Post
     *
     * @ORM\ManyToOne(targetEntity="SxBlog\Entity\Category", inversedBy="categories")
     * @ORM\JoinColumn(onDelete="cascade")
     */
    protected $post;

    /**
     * @param   \SxBlog\Entity\Post     $post
     * @param   \SxBlog\Entity\Category $category
     */
    public function __construct(PostEntity $post, CategoryEntity $category)
    {
        $this->post     = $post;
        $this->category = $category;
    }
    public function getId()
    {
        return $this->id;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function setCategory(CategoryEntity $category)
    {
        $this->category = $category;

        return $this;
    }

    public function getPost()
    {
        return $this->post;
    }

    public function setPost(PostEntity $post)
    {
        $this->post = $post;

        return $this;
    }

}

