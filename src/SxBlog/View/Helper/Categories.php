<?php

namespace SxBlog\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\View\Model\ViewModel;
use SxBlog\Service\CategoryService;
use SxBlog\Entity\Category as CategoryEntity;

class Categories extends AbstractHelper
{

    /**
     * @var \SxBlog\Service\CategoryService
     */
    protected $categoryService;

    /**
     * @var array
     */
    protected $options = array(
        'category'   => array(
            'template'   => 'helper/sx-blog/category',
            'attributes' => array(),
        ),
        'categories' => array(
            'template'   => 'helper/sx-blog/categories',
            'attributes' => array(),
        ),
    );

    /**
     * @param \SxBlog\Service\CategoryService $categoryService
     */
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * @return string
     */
    public function render()
    {
        $categories      = $this->categoryService->getCategories();
        $categoryContent = '';
        $attributes      = $this->renderAttributes($this->options['category']['attributes']);

        foreach ($categories as $category) {
            $categoryContent .= $this->renderCategory($category, $attributes);
        }

        $categoriesTemplate = new ViewModel;

        $categoriesTemplate->setTemplate($this->options['categories']['template']);
        
        $categoriesTemplate->setVariables(array(
            'categories' => $categoryContent,
            'attributes' => $this->renderAttributes($this->options['categories']['attributes']),
        ));

        return $this->view->render($categoriesTemplate);
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
     * @return  \SxBlog\View\Helper\Categories
     */
    public function setOptions(array $options)
    {
        $this->options = array_merge_recursive($this->options, $options);

        return $this;
    }

    /**
     * 
     * @param   \SxBlog\Entity\Category $category
     * 
     * @return  string
     */
    protected function renderCategory(CategoryEntity $categoryEntity, $attributes)
    {
        $category = new ViewModel;

        $category->setTemplate($this->options['category']['template']);

        $category->setVariables(array(
            'category'   => $categoryEntity,
            'attributes' => $attributes,
        ));

        return $this->view->render($category);
    }

    /**
     * Invoke the view helper. Accepts options.
     *  - ViewModel category_template
     *  - ViewModel categories_template
     * 
     * @param   array   $options
     * 
     * @return \SxBlog\View\Helper\Categories
     */
    public function __invoke(array $options = array())
    {
        $this->setOptions($options);

        return $this;
    }

}
