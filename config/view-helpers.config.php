<?php

namespace SxBlog;

use SxBlog\View\Helper\Categories as CategoriesHelper;
use SxBlog\View\Helper\Posts as PostsHelper;
use SxBlog\View\Helper\Post as PostHelper;

return array(
    'factories' => array(
        'sxblogCategories' => function ($sm) {
            $sl = $sm->getServiceLocator();

            return new CategoriesHelper(
                $sl->get('SxBlog\Options\ModuleOptions'),
                $sl->get('SxBlog\Service\CategoryService')
            );
        },
        'sxblogPosts'      => function ($sm) {
            $sl = $sm->getServiceLocator();

            return new PostsHelper(
                $sl->get('SxBlog\Options\ModuleOptions'),
                $sl->get('SxBlog\Service\PostService')
            );
        },
        'sxblogPost'      => function ($sm) {
            $sl = $sm->getServiceLocator();

            return new PostHelper(
                $sl->get('SxBlog\Options\ModuleOptions'),
                $sl->get('SxBlog\Service\PostService')
            );
        },
    ),
);
