<?php

namespace SxBlog\Repository;

use Doctrine\ORM\EntityRepository;

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
}
