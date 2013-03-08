<?php

namespace SxBlog\Controller;

use Doctrine\Common\Persistence\ObjectRepository;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use SxBlog\Entity\Category as CategoryEntity;
use SxBlog\Service\CategoryService;

class CategoryController extends AbstractActionController
{

    /**
     * @var \Doctrine\Common\Persistence\ObjectRepository
     */
    protected $categoryRepository;

    /**
     * @var \Doctrine\Common\Persistence\ObjectRepository
     */
    protected $postRepository;

    /**
     * @var \SxBlog\Service\CategoryService
     */
    protected $categoryService;

    /**
     * @var array
     */
    protected $messages = array(
        'category_creation_success' => 'Category created successfully!',
        'category_creation_fail'    => 'Creating the category failed!',
        'category_update_success'   => 'Category updated successfully!',
        'category_update_fail'      => 'Updating the category failed!',
    );

    /**
     * @param \Doctrine\Common\Persistence\ObjectRepository $categoryRepository
     * @param \SxBlog\Service\CategoryService               $categoryService
     * @param \Doctrine\Common\Persistence\ObjectRepository $postRepository
     */
    public function __construct(
        ObjectRepository $categoryRepository,
        CategoryService $categoryService,
        ObjectRepository $postRepository
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->postRepository     = $postRepository;
        $this->categoryService    = $categoryService;
    }

    /**
     * @return \Zend\View\Model\ViewModel
     */
    public function indexAction()
    {
        return new ViewModel(array(
            'message' => $this->getFlashMessengerMessage('sxblog_category'),
        ));
    }

    /**
     * @return \Zend\Http\Response|\Zend\View\Model\ViewModel
     */
    public function newAction()
    {
        if (!$this->zfcUserAuthentication()->hasIdentity()) {
            return $this->redirect()->toRoute('sx_blog/categories');
        }
        $categoryEntity = new CategoryEntity;
        $form           = $this->getServiceLocator()->get('FormElementManager')->get('SxBlog\Form\CreateCategory');
        $request        = $this->getRequest();
        $message        = null;

        $form->bind($categoryEntity);

        if ($request->isPost()) {
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->categoryService->createCategory($categoryEntity);
                $this->flashMessenger()->setNamespace('sxblog_category')->addMessage(
                    $this->messages['category_creation_success']
                );

                return $this->redirect()->toRoute('sx_blog/categories');
            }

            $message = $this->messages['category_creation_fail'];
        }

        return new ViewModel(array(
            'form'    => $form,
            'message' => $message,
        ));
    }

    /**
     * @return \Zend\Http\Response|\Zend\View\Model\ViewModel
     */
    public function editAction()
    {
        if (!$this->zfcUserAuthentication()->hasIdentity()) {
            return $this->redirect()->toRoute('sx_blog/categories');
        }

        $slug           = $this->params('slug');
        $categoryEntity = $this->categoryRepository->findBySlug($slug);
        $form           = $this->getServiceLocator()->get('FormElementManager')->get('SxBlog\Form\UpdateCategory');
        $request        = $this->getRequest();
        $flashMessenger = $this->flashMessenger()->setNamespace('sxblog_category');
        $message        = $this->getFlashMessengerMessage('sxblog_category');

        $form->bind($categoryEntity);

        if ($request->isPost()) {
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->categoryService->saveCategory($categoryEntity);
                $flashMessenger->addMessage($this->messages['category_update_success']);

                return $this->redirect()->toRoute(
                    'sx_blog/category/edit', array('slug' => $categoryEntity->getSlug())
                );
            }

            $message = $this->messages['category_update_fail'];
        }

        return new ViewModel(array(
            'form'    => $form,
            'message' => $message,
        ));
    }

    /**
     * @param $namespace
     *
     * @return null
     */
    protected function getFlashMessengerMessage($namespace)
    {
        $message        = null;
        $flashMessenger = $this->flashMessenger()->setNamespace($namespace);

        if ($flashMessenger->hasMessages()) {
            $messages = $flashMessenger->getMessages();
            $message  = $messages[0];
        }

        return $message;
    }

    /**
     * @return \Zend\View\Model\ViewModel
     */
    public function listAction()
    {
        $slug     = $this->params('slug');
        $page     = $this->params('page');
        $category = $this->categoryRepository->findBySlug($slug);

        return new ViewModel(array(
            'category' => $category,
            'posts'    => $this->postRepository->findByCategoryPaginated($category, $page),
        ));
    }

}
