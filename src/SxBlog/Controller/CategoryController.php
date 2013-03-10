<?php

namespace SxBlog\Controller;

use Doctrine\Common\Persistence\ObjectRepository;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use SxBlog\Entity\Category as CategoryEntity;
use SxBlog\Exception;
use SxBlog\Options\ModuleOptions;
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
     * @var \SxBlog\Options\ModuleOptions
     */
    protected $options;

    /**
     * @var \SxBlog\Service\CategoryService
     */
    protected $categoryService;

    /**
     * @param \SxBlog\Options\ModuleOptions                 $options
     * @param \Doctrine\Common\Persistence\ObjectRepository $categoryRepository
     * @param \SxBlog\Service\CategoryService               $categoryService
     * @param \Doctrine\Common\Persistence\ObjectRepository $postRepository
     */
    public function __construct(
        ModuleOptions $options,
        ObjectRepository $categoryRepository,
        CategoryService $categoryService,
        ObjectRepository $postRepository
    ) {
        $this->options            = $options;
        $this->categoryRepository = $categoryRepository;
        $this->postRepository     = $postRepository;
        $this->categoryService    = $categoryService;
    }

    /**
     * @param $key
     *
     * @return mixed
     * @throws \SxBlog\Exception\InvalidArgumentException
     */
    protected function getMessage($key)
    {
        $messages = $this->options->getMessages();

        if (!isset($messages[$key])) {
            throw new Exception\InvalidArgumentException(sprintf(
                'Invalid $key supplied for getMessage. Message with key "%s" not found.',
                $key
            ));
        }

        return $messages[$key];
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
                    $this->getMessage('category_creation_success')
                );

                return $this->redirect()->toRoute('sx_blog/categories');
            }

            $message = $this->getMessage('category_creation_fail');
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
                $flashMessenger->addMessage($this->getMessage('category_update_success'));

                return $this->redirect()->toRoute(
                    'sx_blog/category/edit', array('slug' => $categoryEntity->getSlug())
                );
            }

            $message = $this->getMessage('category_update_fail');
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
     * @return \Zend\Http\Response
     */
    public function deleteAction()
    {
        $slug = $this->params('slug');

        $this->categoryService->delete($slug);

        $this->flashMessenger()->setNamespace('sxblog_category')->addMessage(
            $this->getMessage('category_deletion_success')
        );

        return $this->redirect()->toRoute($this->options->getRouteAfterCategoryDelete());
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
