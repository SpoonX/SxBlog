<?php

namespace SxBlog\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
use Zend\Paginator\Paginator;

class CategoryRepository extends EntityRepository
{

    /**
     * @param   string  $slug
     *
     * @return  \SxBlog\Entity\Category
     */
    public function findBySlug($slug)
    {
        return $this->findOneBy(array('slug' => $slug));
    }

}
