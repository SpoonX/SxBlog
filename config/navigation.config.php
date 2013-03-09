<?php

return array(
    'navigation' => array(
        'default' => array(
            'sx_blog'            => array(
                'label '    => 'Posts',
                'route'     => 'sx_blog/posts',
                'resource'  => 'post',
                'privilege' => 'list',
                'pages'     => array(
                    'create' => array(
                        'label '    => 'Create post',
                        'route'     => 'sx_blog/post/new',
                        'resource'  => 'post',
                        'privilege' => 'create',
                    ),
                    'edit'   => array(
                        'route'     => 'sx_blog/post/edit',
                        'visible'   => false,
                        'resource'  => 'post',
                        'privilege' => 'edit',
                    ),
                    'delete' => array(
                        'route'     => 'sx_blog/post/delete',
                        'visible'   => false,
                        'resource'  => 'post',
                        'privilege' => 'create',
                    ),
                    'view'   => array(
                        'route'     => 'sx_blog/post/view',
                        'visible'   => false,
                        'resource'  => 'post',
                        'privilege' => 'view',
                    ),
                ),
            ),
            'sx_blog/categories' => array(
                'label '    => 'Categories',
                'route'     => 'sx_blog/categories',
                'resource'  => 'category',
                'privilege' => 'list',
                'pages'     => array(
                    'create' => array(
                        'label '    => 'Create category',
                        'route'     => 'sx_blog/category/new',
                        'resource'  => 'category',
                        'privilege' => 'create',
                    ),
                    'edit'   => array(
                        'route'     => 'sx_blog/category/edit',
                        'visible'   => false,
                        'resource'  => 'category',
                        'privilege' => 'edit',
                    ),
                    'delete' => array(
                        'route'     => 'sx_blog/category/delete',
                        'visible'   => false,
                        'resource'  => 'category',
                        'privilege' => 'create',
                    ),
                    'view'   => array(
                        'route'     => 'sx_blog/category/view',
                        'visible'   => false,
                        'resource'  => 'category',
                        'privilege' => 'view',
                    ),
                ),
            ),
        ),
    ),
);
