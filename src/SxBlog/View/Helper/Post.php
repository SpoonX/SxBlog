<?php

namespace SxBlog\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\View\Model\ViewModel;
use SxBlog\Entity\Post as PostEntity;

class Post extends AbstractHelper
{

    /**
     * @var \SxBlog\Entity\Post $post
     */
    protected $post;

    /**
     * @var array
     */
    protected $options = array(
        'template'   => 'helper/sx-blog/post',
        'attributes' => array(),
    );

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
     * @return string
     */
    public function render()
    {
        $postViewModel = new ViewModel;

        $postViewModel->setTemplate($this->options['template']);

        $postViewModel->setVariables(array(
            'post'       => $this->getPost(),
            'attributes' => $this->renderAttributes($this->options['attributes']),
        ));

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
     * @param   array $options
     *
     * @return  \SxBlog\View\Helper\Post
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
     * @return \SxBlog\View\Helper\Post
     */
    public function __invoke(array $options = array())
    {
        $this->setOptions($options);

        return $this;
    }

}
