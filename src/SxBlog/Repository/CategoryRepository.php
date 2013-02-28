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
        $category = $this->findOneBy(array('slug' => $slug));

        return $this->findById($category->getId());
    }

    public function findById($id)
    {
        $entityManager   = $this->getEntityManager();
        $entityReference = $entityManager->getReference('SxBlog\Entity\Category', $id);
        $dql             = 'SELECT p FROM SxBlog\Entity\Post p WHERE :category MEMBER OF p.categories ORDER BY p.creationDate desc';

        return $entityManager->createQuery($dql)
                ->setParameter('category', $entityReference)
                ->getResult();
    }

}
