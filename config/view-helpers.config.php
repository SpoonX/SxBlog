<?php

namespace SxBlog;

use SxBlog\View\Helper\Categories as CategoriesHelper;
use SxBlog\View\Helper\Posts as PostsHelper;

return array(
    'factories' => array(
        'sxblogCategories' => function($sm) {
            return new CategoriesHelper($sm->getServiceLocator()->get('SxBlog\Service\CategoryService'));
        },
        'sxblogPosts' => function($sm) {
            return new PostsHelper($sm->getServiceLocator()->get('SxBlog\Service\PostService'));
        },
    ),
);
/**
 * @todo: Cleanup (All files, no debug code, set correct dependencies in json, set correct configs)
 * @todo: Push changes, request final review.
 * @todo: Remove this todo block, push, merge, find next issue from issues list.
 */
