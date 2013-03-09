<?php

namespace SxBlog\Service;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use SxBlog\Entity\Post as PostEntity;

class PostService
{

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $objectManager;

    /**
     * @var \Doctrine\Common\Persistence\ObjectRepository|\SxBlog\Repository\PostRepository
     */
    protected $repository;

    /**
     * @param \Doctrine\Common\Persistence\ObjectManager    $objectManager
     * @param \Doctrine\Common\Persistence\ObjectRepository $repository
     */
    public function __construct(ObjectManager $objectManager, ObjectRepository $repository)
    {
        $this->objectManager = $objectManager;
        $this->repository    = $repository;
    }

    /**
     * @param integer $page
     * @param integer $limit
     *
     * @return mixed
     */
    public function getPosts($page = 1, $limit = 10)
    {
        return $this->repository->findAllPaginated($page, $limit);
    }

    /**
     * @param $slug
     */
    public function delete($slug)
    {
        $this->objectManager->remove($this->repository->findBySlug($slug));
        $this->objectManager->flush();
    }

    /**
     * @param \SxBlog\Entity\Post $postEntity
     */
    public function savePost(PostEntity $postEntity)
    {
        $this->objectManager->flush($postEntity);
    }

    /**
     * @param \SxBlog\Entity\Post $postEntity
     */
    public function createPost(PostEntity $postEntity)
    {
        $this->objectManager->persist($postEntity);
        $this->objectManager->flush($postEntity);
    }
}
