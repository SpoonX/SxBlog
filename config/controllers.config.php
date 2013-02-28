<?php

return array(
    'factories'  => array(
        'SxBlog\Controller\Category' => function($sm) {
            $serviceLocator  = $sm->getServiceLocator();
            $categoryService = $serviceLocator->get('SxBlog\Service\CategoryService');
            $entityManager   = $serviceLocator->get('Doctrine\ORM\EntityManager');

            return new SxBlog\Controller\CategoryController(
                $entityManager,
                $entityManager->getRepository('SxBlog\Entity\Category'),
                $categoryService
            );
        },
        'SxBlog\Controller\Post' => function($sm) {
            $serviceLocator  = $sm->getServiceLocator();
            $categoryService = $serviceLocator->get('SxBlog\Service\PostService');
            $entityManager   = $serviceLocator->get('Doctrine\ORM\EntityManager');

            return new SxBlog\Controller\PostController(
                $entityManager,
                $entityManager->getRepository('SxBlog\Entity\Post'),
                $categoryService
            );
        },
    ),
);
