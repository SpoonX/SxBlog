<?php

namespace SxBlog\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\View\Model\ViewModel;
use SxBlog\Service\PostService;
use Doctrine\Common\Collections\Collection;

class Posts extends AbstractHelper
{

    /**
     * @var \SxBlog\Service\PostService
     */
    protected $postService;

    /**
     * @var \Doctrine\Common\Collections\Collection $posts
     */
    protected $posts;

    /**
     * @var array
     */
    protected $options = array(
        'template'   => 'helper/sx-blog/posts',
        'attributes' => array(),
    );

    /**
     * @param \SxBlog\Service\PostService $postService
     */
    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    /**
     *
     * @param \Doctrine\Common\Collections\Collection $posts
     *
     * @return  \SxBlog\View\Helper\Posts
     */
    public function setPosts(Collection $posts)
    {
        $this->posts = $posts;

        return $this;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPosts()
    {
        if (null === $this->posts) {
            $this->posts = $this->postService->getPosts();
        }

        return $this->posts;
    }

    /**
     * @return string
     */
    public function render()
    {
        $posts          = $this->getPosts();
        $postContent    = '';
        $postRenderer   = $this->getView()->plugin('sxblog_post');

        foreach ($posts as $post) {
            $postContent .= $postRenderer->setPost($post)->render();
        }

        $postsviewModel = new ViewModel;

        $postsviewModel->setTemplate($this->options['template']);

        $postsviewModel->setVariables(array(
            'posts'      => $postContent,
            'attributes' => $this->renderAttributes($this->options['attributes']),
        ));

        return $this->getView()->render($postsviewModel);
    }

    /**
     * @param   array $arguments
     *
     * @return  string
     */
    protected function renderAttributes(array $arguments)
    {
        if (empty($arguments)) {
            return '';
        }

        $argumentsString = '';

        foreach ($arguments as $key => $value) {
            $argumentsString .= " {$key}=\"{$value}\"";
        }

        return $argumentsString;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->render();
    }

    /**
     * @param   array $options
     *
     * @return  \SxBlog\View\Helper\Posts
     */
    public function setOptions(array $options)
    {
        $this->options = array_merge_recursive($this->options, $options);

        return $this;
    }

    /**
     * Invoke the view helper. Accepts options.
     *
     * @param   array   $options
     *
     * @return \SxBlog\View\Helper\Posts
     */
    public function __invoke(array $options = array())
    {
        $this->setOptions($options);

        return $this;
    }

}
