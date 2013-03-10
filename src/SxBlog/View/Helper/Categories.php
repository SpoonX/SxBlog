<?php

namespace SxBlog\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\View\Model\ViewModel;
use SxBlog\Service\CategoryService;
use SxBlog\Entity\Category as CategoryEntity;
use SxBlog\Options\ModuleOptions;
use Doctrine\Common\Collections\Collection;

class Categories extends AbstractHelper
{

    /**
     * @var \SxBlog\Service\CategoryService
     */
    protected $categoryService;

    /**
     * @var \Doctrine\Common\Collections\Collection $categories
     */
    protected $categories;

    /**
     * @var \SxBlog\Options\ModuleOptions
     */
    protected $options;

    /**
     * @param ModuleOptions                   $options
     * @param \SxBlog\Service\CategoryService $categoryService
     */
    public function __construct(ModuleOptions $options, CategoryService $categoryService)
    {
        $this->options         = $options;
        $this->categoryService = $categoryService;
    }

    /**
     *
     * @param \Doctrine\Common\Collections\Collection $categories
     */
    public function setCategories(Collection $categories)
    {
        $this->categories = $categories;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategories()
    {
        if (null === $this->categories) {
            $this->categories = $this->categoryService->getCategories();
        }

        return $this->categories;
    }

    /**
     * @return string
     */
    public function render()
    {
        $categories      = $this->getCategories();
        $categoryContent = '';
        $attributes      = $this->renderAttributes($this->options->getCategoryAttributes());

        foreach ($categories as $category) {
            $categoryContent .= $this->renderCategory($category, $attributes);
        }

        $categoriesViewModel = new ViewModel;

        $categoriesViewModel->setTemplate($this->options->getCategoriesContainerTemplate());

        $categoriesViewModel->setVariables(array(
            'categories' => $categoryContent,
            'attributes' => $this->renderAttributes($this->options->getCategoryContainerAttributes()),
        ));

        return $this->getView()->render($categoriesViewModel);
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
     * @param \SxBlog\Entity\Category $categoryEntity
     * @param string                  $attributes
     *
     * @return string
     */
    protected function renderCategory(CategoryEntity $categoryEntity, $attributes)
    {
        $categoryViewModel = new ViewModel;

        $categoryViewModel->setTemplate($this->options->getCategoryTemplate());

        $categoryViewModel->setVariables(array(
            'category'   => $categoryEntity,
            'attributes' => $attributes,
        ));

        return $this->getView()->render($categoryViewModel);
    }

    /**
     * Invoke the view helper. Accepts options.
     *
     * @param   array|\Traversable   $options
     *
     * @return \SxBlog\View\Helper\Categories
     */
    public function __invoke(array $options = array())
    {
        if (!empty($options)) {
            $this->options->setFromArray($options);
        }

        return $this;
    }

}
