<?php

namespace SxBlog\Controller;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use SxBlog\Entity\Post as PostEntity;
use SxBlog\Form\CreatePost as CreatePostForm;
use SxBlog\Form\UpdatePost as UpdatePostForm;
use SxBlog\Service\PostService;

class PostController extends AbstractActionController
{

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $entityManager;

    /**
     * @var \SxBlog\Repository\Category\Repository
     */
    protected $repository;

    /**
     * @var \SxBlog\Service\PostService
     */
    protected $postService;

    /**
     * @var array
     */
    protected $messages = array(
        'post_creation_success' => 'Post created successfully!',
        'post_creation_fail'    => 'Creating the post failed!',
        'post_update_success'   => 'Post updated successfully!',
        'post_update_fail'      => 'Updating the post failed!',
    );

    /**
     * @param   \Doctrine\ORM\EntityManager             $entityManager
     * @param   \SxBlog\Repository\Category\Repository  $repository
     * @param   \SxBlog\Service\PostService             $postService
     */
    public function __construct(EntityManager $entityManager, EntityRepository $repository, PostService $postService)
    {
        $this->entityManager = $entityManager;
        $this->repository    = $repository;
        $this->postService   = $postService;
    }

    public function indexAction()
    {
        return new ViewModel(array(
            'message' => $this->getFlashMessengerMessage('sxblog_post'),
        ));
    }

    public function editAction()
    {
        if (!$this->zfcUserAuthentication()->hasIdentity()) {
            return $this->redirect()->toRoute('sx_blog/posts');
        }

        $slug           = $this->params('slug');
        $postEntity     = $this->repository->findBySlug($slug);
        $form           = new UpdatePostForm($this->getServiceLocator());
        $request        = $this->getRequest();
        $flashMessenger = $this->flashMessenger()->setNamespace('sxblog_post');
        $message        = $this->getFlashMessengerMessage('sxblog_post');

        $form->bind($postEntity);

        if ($request->isPost()) {
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $user = $this->zfcUserAuthentication()->getIdentity();

                $postEntity->setAuthor($user);
                $this->postService->savePost($postEntity);
                $flashMessenger->addMessage($this->messages['post_update_success']);

                return $this->redirect()->toUrl($this->url()->fromRoute(
                    'sx_blog/post/edit', array('slug' => $postEntity->getSlug())
                ));
            }

            $message = $this->messages['post_update_fail'];
        }

        return new ViewModel(array(
            'form'    => $form,
            'message' => $message,
        ));
    }

    public function newAction()
    {
        if (!$this->zfcUserAuthentication()->hasIdentity()) {
            return $this->redirect()->toRoute('sx_blog/posts');
        }
        $postEntity     = new PostEntity;
        $form           = new CreatePostForm($this->getServiceLocator());
        $request        = $this->getRequest();
        $message        = null;

        $form->bind($postEntity);

        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {

                $user = $this->zfcUserAuthentication()->getIdentity();

                $postEntity->setAuthor($user);
                $this->postService->createPost($postEntity);
                $this->flashMessenger()->setNamespace('sxblog_post')->addMessage($this->messages['post_creation_success']);

                return $this->redirect()->toUrl($this->url()->fromRoute('sx_blog/post/edit', array('slug' => $postEntity->getSlug())));
            }

            $message = $this->messages['post_creation_fail'];
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
            return $this->redirect()->toRoute('SxBlog/categories');
        }
    }

    public function listAction()
    {
    }

}
