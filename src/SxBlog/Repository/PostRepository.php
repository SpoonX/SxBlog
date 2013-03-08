<?php

namespace SxBlog\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
use Zend\Paginator\Paginator;
use SxBlog\Entity\Category as CategoryEntity;

class PostRepository extends EntityRepository
{

    /**
     * @param   string  $slug
     *
     * @return  \SxBlog\Entity\Post
     */
    public function findBySlug($slug)
    {
        return $this->findOneBy(array('slug' => $slug));
    }

    /**
     * @param int $page
     * @param int $limit
     *
     * @return \Zend\Paginator\Paginator
     */
    public function findAllPaginated($page = 1, $limit = 10)
    {
        $queryBuilder     = $this->createQueryBuilder('p');
        $ORMPaginator     = new ORMPaginator($queryBuilder->getQuery(), false);
        $paginatorAdapter = new DoctrinePaginator($ORMPaginator);
        $paginator        = new Paginator($paginatorAdapter);

        $paginator->setItemCountPerPage($limit);
        $paginator->setCurrentPageNumber($page);

        return $paginator;
    }

    /**
     * @param \SxBlog\Entity\Category $category
     * @param int                     $page
     * @param int                     $limit
     *
     * @return \Zend\Paginator\Paginator
     */
    public function findByCategoryPaginated(CategoryEntity $category, $page = 1, $limit = 10)
    {
        $queryBuilder = $this->createQueryBuilder('p');

        $queryBuilder->join('p.categories', 'c')->where('c = :category')->setParameter('category', $category);

        $ORMPaginator     = new ORMPaginator($queryBuilder->getQuery(), false);
        $paginatorAdapter = new DoctrinePaginator($ORMPaginator);
        $paginator        = new Paginator($paginatorAdapter);

        $paginator->setItemCountPerPage($limit);
        $paginator->setCurrentPageNumber($page);

        return $paginator;
    }
}
