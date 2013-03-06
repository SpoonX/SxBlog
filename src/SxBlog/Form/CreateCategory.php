<?php

namespace SxBlog\Form;

use Zend\Form\Form;
use Zend\Form\Element\Csrf;

class CreateCategory extends Form
{

    public function __construct()
    {
        parent::__construct('create-category-form');

        $this->add(new Csrf('csrf'));

        $this->add(array(
            'name'       => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Save'
            )
        ));
    }

}
