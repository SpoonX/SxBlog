<?php

namespace SxBlog\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
use Zend\Paginator\Paginator;

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
     * @param integer $page
     * @param integer $limit
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
}
