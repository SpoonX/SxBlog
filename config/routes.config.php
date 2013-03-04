<?php

return array(
    'router' => array(
        'routes' => array(
            'sx_blog' => array(
                'type'         => 'Literal',
                'may_terminate' => true,
                'options'      => array(
                    'route'    => '/blog',
                    'defaults' => array(
                        'controller' => 'SxBlog\Controller\Blog',
                        'action'     => 'index',
                    ),
                ),
                'child_routes' => array(
                    'post'   => array(
                        'type'          => 'Literal',
                        'may_terminate' => true,
                        'options'       => array(
                            'route' => '/post',
                        ),
                        'child_routes'  => array(
                            'new' => array(
                                'type'    => 'Segment',
                                'options' => array(
                                    'route'    => '/new',
                                    'defaults' => array(
                                        'controller' => 'SxBlog\Controller\Post',
                                        'action'     => 'new',
                                    ),
                                ),
                            ),
                            'edit' => array(
                                'type'    => 'Segment',
                                'options' => array(
                                    'route'    => '/edit/:slug',
                                    'defaults' => array(
                                        'controller' => 'SxBlog\Controller\Post',
                                        'action'     => 'edit',
                                    ),
                                ),
                            ),
                            'view'   => array(
                                'type'    => 'Segment',
                                'options' => array(
                                    'route'    => '/view/:slug',
                                    'defaults' => array(
                                        'controller' => 'SxBlog\Controller\Post',
                                        'action'     => 'list',
                                    ),
                                ),
                            ),
                            'delete'   => array(
                                'type'    => 'Segment',
                                'options' => array(
                                    'route'    => '/delete/:slug',
                                    'defaults' => array(
                                        'controller' => 'SxBlog\Controller\Post',
                                        'action'     => 'delete',
                                    ),
                                ),
                            ),
                        ),
                    ),
                    'posts' => array(
                        'type'    => 'Literal',
                        'options' => array(
                            'route'    => '/posts',
                            'defaults' => array(
                                'controller' => 'SxBlog\Controller\Post',
                                'action'     => 'index',
                            ),
                        ),
                    ),
                    'categories' => array(
                        'type'    => 'Literal',
                        'options' => array(
                            'route'    => '/categories',
                            'defaults' => array(
                                'controller' => 'SxBlog\Controller\Category',
                                'action'     => 'index',
                            ),
                        ),
                    ),
                    'category'   => array(
                        'type'          => 'Literal',
                        'may_terminate' => true,
                        'options'       => array(
                            'route' => '/category',
                        ),
                        'child_routes'  => array(
                            'new' => array(
                                'type'    => 'Segment',
                                'options' => array(
                                    'route'    => '/new',
                                    'defaults' => array(
                                        'controller' => 'SxBlog\Controller\Category',
                                        'action'     => 'new',
                                    ),
                                ),
                            ),
                            'edit' => array(
                                'type'    => 'Segment',
                                'options' => array(
                                    'route'    => '/edit/:slug',
                                    'defaults' => array(
                                        'controller' => 'SxBlog\Controller\Category',
                                        'action'     => 'edit',
                                    ),
                                ),
                            ),
                            'view'   => array(
                                'type'    => 'Segment',
                                'options' => array(
                                    'route'    => '/view/:slug',
                                    'defaults' => array(
                                        'controller' => 'SxBlog\Controller\Category',
                                        'action'     => 'list',
                                    ),
                                ),
                            ),
                            'delete'   => array(
                                'type'    => 'Segment',
                                'options' => array(
                                    'route'    => '/delete/:slug',
                                    'defaults' => array(
                                        'controller' => 'SxBlog\Controller\Category',
                                        'action'     => 'delete',
                                    ),
                                ),
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
);
