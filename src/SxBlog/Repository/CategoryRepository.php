<?php

namespace SxBlog\Repository;

use Doctrine\ORM\EntityRepository;

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
