<?php

namespace SxBlog\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use SxBlog\Entity\Post as PostEntity;
use SxBlog\Exception;
use SxBlog\Options\ModuleOptions;
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
     * @var \SxBlog\Options\ModuleOptions
     */
    protected $options;

    /**
     * @param \SxBlog\Options\ModuleOptions                 $options
     * @param \Doctrine\Common\Persistence\ObjectRepository $repository
     * @param \SxBlog\Service\PostService                   $postService
     */
    public function __construct(ModuleOptions $options, ObjectRepository $repository, PostService $postService)
    {
        $this->options     = $options;
        $this->repository  = $repository;
        $this->postService = $postService;
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
    public function listAction()
    {
        return new ViewModel(
            array(
                'page'    => $this->params('page', 1),
                'message' => $this->getFlashMessengerMessage('sxblog_post'),
            )
        );
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
                $flashMessenger->addMessage($this->getMessage('post_update_success'));

                return $this->redirect()->toRoute(
                    'sx_blog/post/edit', array('slug' => $postEntity->getSlug())
                );
            }

            $message = $this->getMessage('post_update_fail');
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
                $this->flashMessenger()->setNamespace('sxblog_post')->addMessage(
                    $this->getMessage('post_creation_success')
                );

                return $this->redirect()->toRoute('sx_blog/post/edit', array('slug' => $postEntity->getSlug()));
            }

            $message = $this->getMessage('post_creation_fail');
        }

        return new ViewModel(array(
            'form'    => $form,
            'message' => $message,
        ));

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

    /**
     * @return \Zend\Http\Response
     */
    public function deleteAction()
    {
        $slug = $this->params('slug');

        $this->postService->delete($slug);

        $this->flashMessenger()->setNamespace('sxblog_post')->addMessage(
            $this->getMessage('post_deletion_success')
        );

        return $this->redirect()->toRoute($this->options->getRouteAfterPostDelete());
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

}
