<?php

namespace SxBlog\Options;

use Zend\Stdlib\AbstractOptions;

class ModuleOptions extends AbstractOptions
{

    /**
     * Turn off strict options mode
     */
    protected $__strictMode__ = false;

    /**
     * @var bool
     */
    protected $useExcerpt = false;

    /**
     * @var int
     */
    protected $excerptLength = 350;

    /**
     * @var string
     */
    protected $postsContainerTemplate = 'helper/sx-blog/posts';

    /**
     * @var array
     */
    protected $postsContainerAttributes = array();

    /**
     * @var int
     */
    protected $postsPerPage = 10;

    /**
     * @var string
     */
    protected $postTemplate = 'helper/sx-blog/post';

    /**
     * @var array
     */
    protected $postAttributes = array();

    /**
     * @var array
     */
    protected $categoryAttributes = array();

    /**
     * @var array
     */
    protected $categoryContainerAttributes = array();

    /**
     * @var string
     */
    protected $categoryTemplate = 'helper/sx-blog/category';

    /**
     * @var string
     */
    protected $categoriesContainerTemplate = 'helper/sx-blog/categories';

    /**
     * @var string
     */
    protected $routeAfterPostDelete = 'sx_blog/posts';

    /**
     * @var string
     */
    protected $routeAfterCategoryDelete = 'sx_blog/categories';

    /**
     * @var array
     */
    protected $messages = array(
        'category_creation_success' => 'Category created successfully!',
        'category_creation_fail'    => 'Creating the category failed!',
        'category_update_success'   => 'Category updated successfully!',
        'category_update_fail'      => 'Updating the category failed!',
        'category_deletion_success' => 'Category deleted successfully!',
        'post_creation_success'     => 'Post created successfully!',
        'post_creation_fail'        => 'Creating the post failed!',
        'post_update_success'       => 'Post updated successfully!',
        'post_update_fail'          => 'Updating the post failed!',
        'post_deletion_success'     => 'Post deleted successfully!',
    );

    /**
     * @param array $categoryAttributes
     */
    public function setCategoryAttributes($categoryAttributes)
    {
        $this->categoryAttributes = $categoryAttributes;
    }

    /**
     * @return array
     */
    public function getCategoryAttributes()
    {
        return $this->categoryAttributes;
    }

    /**
     * @param array $categoryContainerAttributes
     */
    public function setCategoryContainerAttributes($categoryContainerAttributes)
    {
        $this->categoryContainerAttributes = $categoryContainerAttributes;
    }

    /**
     * @return array
     */
    public function getCategoryContainerAttributes()
    {
        return $this->categoryContainerAttributes;
    }


    /**
     * @param string $routeAfterCategoryDelete
     */
    public function setRouteAfterCategoryDelete($routeAfterCategoryDelete)
    {
        $this->routeAfterCategoryDelete = $routeAfterCategoryDelete;
    }

    /**
     * @return string
     */
    public function getRouteAfterCategoryDelete()
    {
        return $this->routeAfterCategoryDelete;
    }

    /**
     * @param string $routeAfterPostDelete
     */
    public function setRouteAfterPostDelete($routeAfterPostDelete)
    {
        $this->routeAfterPostDelete = $routeAfterPostDelete;
    }

    /**
     * @return string
     */
    public function getRouteAfterPostDelete()
    {
        return $this->routeAfterPostDelete;
    }

    /**
     * @param array $messages
     */
    public function setMessages($messages)
    {
        $this->messages = $messages;
    }

    /**
     * @return array
     */
    public function getMessages()
    {
        return $this->messages;
    }

    /**
     * @param $categoriesContainerTemplate
     */
    public function setCategoriesContainerTemplate($categoriesContainerTemplate)
    {
        $this->categoriesContainerTemplate = $categoriesContainerTemplate;
    }

    /**
     * @return string
     */
    public function getCategoriesContainerTemplate()
    {
        return $this->categoriesContainerTemplate;
    }

    /**
     * @param $categoryTemplate
     */
    public function setCategoryTemplate($categoryTemplate)
    {
        $this->categoryTemplate = $categoryTemplate;
    }

    /**
     * @return string
     */
    public function getCategoryTemplate()
    {
        return $this->categoryTemplate;
    }

    /**
     * @param $excerptLength
     */
    public function setExcerptLength($excerptLength)
    {
        $this->excerptLength = $excerptLength;
    }

    /**
     * @return int
     */
    public function getExcerptLength()
    {
        return $this->excerptLength;
    }

    /**
     * @param $postAttributes
     */
    public function setPostAttributes($postAttributes)
    {
        $this->postAttributes = $postAttributes;
    }

    /**
     * @return array
     */
    public function getPostAttributes()
    {
        return $this->postAttributes;
    }

    /**
     * @param $postTemplate
     */
    public function setPostTemplate($postTemplate)
    {
        $this->postTemplate = $postTemplate;
    }

    /**
     * @return string
     */
    public function getPostTemplate()
    {
        return $this->postTemplate;
    }

    /**
     * @param $postsContainerAttributes
     */
    public function setPostsContainerAttributes($postsContainerAttributes)
    {
        $this->postsContainerAttributes = $postsContainerAttributes;
    }

    /**
     * @return array
     */
    public function getPostsContainerAttributes()
    {
        return $this->postsContainerAttributes;
    }

    /**
     * @param $postsContainerTemplate
     */
    public function setPostsContainerTemplate($postsContainerTemplate)
    {
        $this->postsContainerTemplate = $postsContainerTemplate;
    }

    /**
     * @return string
     */
    public function getPostsContainerTemplate()
    {
        return $this->postsContainerTemplate;
    }

    /**
     * @param $postsPerPage
     */
    public function setPostsPerPage($postsPerPage)
    {
        $this->postsPerPage = $postsPerPage;
    }

    /**
     * @return int
     */
    public function getPostsPerPage()
    {
        return $this->postsPerPage;
    }

    /**
     * @param $useExcerpt
     */
    public function setUseExcerpt($useExcerpt)
    {
        $this->useExcerpt = $useExcerpt;
    }

    /**
     * @return bool
     */
    public function getUseExcerpt()
    {
        return $this->useExcerpt;
    }
}
