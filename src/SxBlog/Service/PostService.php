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
     * @var \Doctrine\ORM\EntityRepository
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
     * @return array
     */
    public function getPosts()
    {
        return $this->repository->findAll();
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
