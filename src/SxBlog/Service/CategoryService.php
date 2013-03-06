<?php

namespace SxBlog\Service;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use SxBlog\Entity\Category as CategoryEntity;

class CategoryService
{

    /**
     * @var \Doctrine\Common\Persistence\ObjectManager
     */
    protected $objectManager;

    /**
     * @var \Doctrine\Common\Persistence\ObjectRepository
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
    public function getCategories()
    {
        return $this->repository->findAll();
    }

    /**
     * @param \SxBlog\Entity\Category $categoryEntity
     */
    public function saveCategory(CategoryEntity $categoryEntity)
    {
        $this->objectManager->flush($categoryEntity);
    }

    /**
     * @param \SxBlog\Entity\Category $categoryEntity
     */
    public function createCategory(CategoryEntity $categoryEntity)
    {
        $this->objectManager->persist($categoryEntity);
        $this->objectManager->flush($categoryEntity);
    }
}
