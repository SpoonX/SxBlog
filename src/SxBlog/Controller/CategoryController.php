<?php

namespace SxBlog\Controller;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use SxBlog\Entity\Category as CategoryEntity;
use SxBlog\Form\UpdateCategory as UpdateCategoryForm;
use SxBlog\Form\CreateCategory as CreateCategoryForm;
use SxBlog\Service\CategoryService;

class CategoryController extends AbstractActionController
{

    /**
     * @var \Doctrine\Common\Persistence\ObjectManager
     */
    protected $entityManager;

    /**
     * @var \SxBlog\Repository\Category\Repository
     */
    protected $repository;

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
     * @param   \Doctrine\ORM\EntityManager             $entityManager
     * @param   \SxBlog\Repository\Category\Repository  $repository
     * @param   \SxBlog\Service\CategoryService         $categoryService
     */
    public function __construct(ObjectManager $entityManager, ObjectRepository $repository, CategoryService $categoryService)
    {
        $this->entityManager   = $entityManager;
        $this->repository      = $repository;
        $this->categoryService = $categoryService;
    }

    public function indexAction()
    {
        return new ViewModel(array(
            'message' => $this->getFlashMessengerMessage('sxblog_category'),
        ));
    }

    public function newAction()
    {
        if (!$this->zfcUserAuthentication()->hasIdentity()) {
            return $this->redirect()->toRoute('sx_blog/categories');
        }
        $categoryEntity = new CategoryEntity;
        $form           = new CreateCategoryForm($this->getServiceLocator());
        $request        = $this->getRequest();
        $message        = null;

        $form->bind($categoryEntity);

        if ($request->isPost()) {
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->categoryService->createCategory($categoryEntity);
                $this->flashMessenger()->setNamespace('sxblog_category')->addMessage($this->messages['category_creation_success']);

                return $this->redirect()->toUrl($this->url()->fromRoute('sx_blog/categories'));
            }

            $message = $this->messages['category_creation_fail'];
        }

        return new ViewModel(array(
            'form'    => $form,
            'message' => $message,
        ));
    }

    public function editAction()
    {
        if (!$this->zfcUserAuthentication()->hasIdentity()) {
            return $this->redirect()->toRoute('sx_blog/categories');
        }

        $slug           = $this->params('slug');
        $categoryEntity = $this->repository->findBySlug($slug);
        $form           = new UpdateCategoryForm($this->getServiceLocator());
        $request        = $this->getRequest();
        $flashMessenger = $this->flashMessenger()->setNamespace('sxblog_category');
        $message        = $this->getFlashMessengerMessage('sxblog_category');

        $form->bind($categoryEntity);

        if ($request->isPost()) {
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->categoryService->saveCategory($categoryEntity);
                $flashMessenger->addMessage($this->messages['category_update_success']);

                return $this->redirect()->toUrl($this->url()->fromRoute(
                    'sx_blog/category/edit', array('slug' => $categoryEntity->getSlug())
                ));
            }

            $message = $this->messages['category_update_fail'];
        }

        return new ViewModel(array(
            'form'    => $form,
            'message' => $message,
        ));
    }

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

    public function deleteAction()
    {
        if (!$this->zfcUserAuthentication()->hasIdentity()) {
            return $this->redirect()->toRoute('sx_blog/categories');
        }
    }

    public function listAction()
    {
        $slug = $this->params('slug');

        $posts = $this->repository->findBySlug($slug);

        foreach($posts as $post) {
            var_dump($post->getTitle());
        }
        //findByCategory
    }

}
