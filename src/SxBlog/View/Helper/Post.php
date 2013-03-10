<?php

namespace SxBlog\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\View\Model\ViewModel;
use SxBlog\Entity\Post as PostEntity;
use SxBlog\Options\ModuleOptions;
use SxBlog\Service\PostService;

class Post extends AbstractHelper
{

    /**
     * @var \SxBlog\Service\PostService
     */
    protected $postService;

    /**
     * @var \SxBlog\Entity\Post $post
     */
    protected $post;

    /**
     * @var \SxBlog\Options\ModuleOptions
     */
    protected $options;

    /**
     * @param \SxBlog\Options\ModuleOptions $options
     * @param \SxBlog\Service\PostService   $postService
     */
    public function __construct(ModuleOptions $options, PostService $postService)
    {
        $this->options     = $options;
        $this->postService = $postService;
    }

    /**
     * @param \SxBlog\Entity\Post $post
     *
     * @return Post
     */
    public function setPost(PostEntity $post)
    {
        $this->post = $post;

        return $this;
    }

    /**
     * @return \SxBlog\Entity\Post
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * @param bool $excerpt
     *
     * @return string
     */
    public function render($excerpt = false)
    {
        $postViewModel = new ViewModel;

        $postViewModel->setTemplate($this->options->getPostTemplate());
        $postViewModel->setVariables(array(
            'useExcerpt' => $excerpt,
            'post'       => $this->getPost(),
            'attributes' => $this->renderAttributes($this->options->getPostAttributes()),
        ));

        if ($excerpt) {
            $postViewModel->setVariable(
                'excerpt',
                $this->postService->getExcerpt(
                    $this->getPost(),
                    $this->options->getExcerptLength()
                )
            );
        }

        return $this->getView()->render($postViewModel);
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
     * Invoke the view helper. Accepts options.
     *
     * @param   array|\Traversable   $options
     *
     * @return \SxBlog\View\Helper\Post
     */
    public function __invoke($options = array())
    {
        if (!empty($options)) {
            $this->options->setFromArray($options);
        }

        return $this;
    }

}
