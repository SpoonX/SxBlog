<?php

namespace SxBlog\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use SxBlog\Entity\Post as PostEntity;
use SxBlog\Service\PostService;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;

class PostController extends AbstractActionController
{

    /**
     * @var \Doctrine\Common\Persistence\ObjectManager
     */
    protected $objectManager;

    /**
     * @var \Doctrine\Common\Persistence\ObjectRepository|\Doctrine\ORM\EntityRepository
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
     * @param \Doctrine\Common\Persistence\ObjectRepository $repository
     * @param \SxBlog\Service\PostService                   $postService
     */
    public function __construct(ObjectRepository $repository, PostService $postService)
    {
        $this->repository    = $repository;
        $this->postService   = $postService;
    }

    /**
     * @return \Zend\View\Model\ViewModel
     */
    public function listAction()
    {
        return new ViewModel;
    }

    /**
     * @return \Zend\Http\Response|\Zend\View\Model\ViewModel
     */
    public function editAction()
    {
        if (!$this->zfcUserAuthentication()->hasIdentity()) {
            return $this->redirect()->toRoute('sx_blog/posts');
        }

        $slug           = $this->params('slug');
        $postEntity     = $this->repository->findBySlug($slug);
        $form           = $this->getServiceLocator()->get('FormElementManager')->get('SxBlog\Form\UpdatePost');
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

                return $this->redirect()->toRoute(
                    'sx_blog/post/edit', array('slug' => $postEntity->getSlug())
                );
            }

            $message = $this->messages['post_update_fail'];
        }

        return new ViewModel(array(
            'form'    => $form,
            'message' => $message,
        ));
    }

    /**
     * @return \Zend\Http\Response|\Zend\View\Model\ViewModel
     */
    public function newAction()
    {
        if (!$this->zfcUserAuthentication()->hasIdentity()) {
            return $this->redirect()->toRoute('sx_blog/posts');
        }
        $postEntity = new PostEntity;
        $form       = $this->getServiceLocator()->get('FormElementManager')->get('SxBlog\Form\CreatePost');
        $request    = $this->getRequest();
        $message    = null;

        $form->bind($postEntity);

        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {

                $user = $this->zfcUserAuthentication()->getIdentity();

                $postEntity->setAuthor($user);
                $this->postService->createPost($postEntity);
                $this->flashMessenger()->setNamespace('sxblog_post')->addMessage($this->messages['post_creation_success']);

                return $this->redirect()->toRoute('sx_blog/post/edit', array('slug' => $postEntity->getSlug()));
            }

            $message = $this->messages['post_creation_fail'];
        }

        return new ViewModel(array(
            'form'    => $form,
            'message' => $message,
        ));

    }

    /**
     * @param $namespace
     *
     * @return null|string
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
    public function viewAction()
    {
        $slug = $this->params('slug');
        $post = $this->repository->findBySlug($slug);

        return new ViewModel(array(
            'post' => $post,
        ));
    }

}
