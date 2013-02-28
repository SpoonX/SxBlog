<?php

namespace SxBlog\Form;

use Zend\Form\Form;
use Zend\Form\Element\Csrf;
use Zend\ServiceManager\ServiceManager;

class UpdateCategory extends Form
{

    public function __construct(ServiceManager $serviceManager)
    {
        parent::__construct('update-category-form');

        $categoryFieldset = new Fieldset\Category($serviceManager);

        $categoryFieldset->setUseAsBaseFieldset(true);
        $this->add($categoryFieldset);
        
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
