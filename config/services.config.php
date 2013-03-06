<?php

namespace SxBlog;

use SxBlog\Service\PostService;
use SxBlog\Service\CategoryService;

return array(
    'factories' => array(
        'SxBlog\Service\PostService' => function($sm) {
            $entityManager = $sm->get('Doctrine\ORM\EntityManager');
            
            return new PostService(
                $entityManager,
                $entityManager->getRepository('SxBlog\Entity\Post')
            );
        },
        'SxBlog\Service\CategoryService' => function($sm) {
            $entityManager = $sm->get('Doctrine\ORM\EntityManager');
            
            return new CategoryService(
                $entityManager,
                $entityManager->getRepository('SxBlog\Entity\Category')
            );
        },
    ),
);
