<?php

namespace SxBlog;

return array(
    'view_manager' => array(
        'template_map' => array(
            'sx-blog/category/index'    => __DIR__ . '/../view/sx-blog/category/index.phtml',
            'sx-blog/category/list'     => __DIR__ . '/../view/sx-blog/category/list.phtml',
            'sx-blog/category/edit'     => __DIR__ . '/../view/sx-blog/category/edit.phtml',
            'sx-blog/category/new'      => __DIR__ . '/../view/sx-blog/category/new.phtml',
            'sx-blog/post/list'         => __DIR__ . '/../view/sx-blog/post/list.phtml',
            'sx-blog/post/view'         => __DIR__ . '/../view/sx-blog/post/view.phtml',
            'sx-blog/post/edit'         => __DIR__ . '/../view/sx-blog/post/edit.phtml',
            'helper/sx-blog/categories' => __DIR__ . '/../view/helper/sx-blog/categories.phtml',
            'sx-blog/post/new'          => __DIR__ . '/../view/sx-blog/post/new.phtml',
            'helper/sx-blog/category'   => __DIR__ . '/../view/helper/sx-blog/category.phtml',
            'helper/sx-blog/post'       => __DIR__ . '/../view/helper/sx-blog/post.phtml',
            'helper/sx-blog/posts'      => __DIR__ . '/../view/helper/sx-blog/posts.phtml',
            'helper/sx-blog/pagination' => __DIR__ . '/../view/helper/sx-blog/pagination.phtml',
        ),
    ),
    'doctrine'     => array(
        'driver' => array(
            strtolower(__NAMESPACE__) => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity'),
            ),
            'orm_default'             => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Entity' => strtolower(__NAMESPACE__),
                ),
            ),
        ),
    ),
);
