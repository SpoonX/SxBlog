<?php

namespace SxBlog\Service;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use SxBlog\Entity\Category as CategoryEntity;

class CategoryService
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

    public function getCategories()
    {
        return $this->repository->findAll();
    }

    public function saveCategory(CategoryEntity $categoryEntity)
    {
        $this->entityManager->flush($categoryEntity);
    }

    public function createCategory(CategoryEntity $categoryEntity)
    {
        $this->entityManager->persist($categoryEntity);
        $this->entityManager->flush($categoryEntity);
    }
}
