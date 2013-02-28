<?php

namespace SxBlog;

use SxBlog\View\Helper\Categories as CategoriesHelper;

return array(
    'factories' => array(
        'sxblogCategories' => function($sm) {
            return new CategoriesHelper($sm->getServiceLocator()->get('SxBlog\Service\CategoryService'));
        },
    ),
);
