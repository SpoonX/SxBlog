<?php

namespace SxBlog\Service;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use SxBlog\Entity\Post as PostEntity;

class PostService
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $entityManager;

    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    protected $repository;

    /**
     * @param   \Doctrine\ORM\EntityManager     $entityManager
     * @param   \Doctrine\ORM\EntityRepository  $repository
     */
    public function __construct(EntityManager $entityManager, EntityRepository $repository)
    {
        $this->entityManager    = $entityManager;
        $this->repository       = $repository;
    }

    public function getPosts()
    {
        return $this->repository->findAll();
    }

    public function savePost(PostEntity $postEntity)
    {
        $this->entityManager->flush($postEntity);
    }

    public function createPost(PostEntity $postEntity)
    {
        $this->entityManager->persist($postEntity);
        $this->entityManager->flush($postEntity);
    }
}
