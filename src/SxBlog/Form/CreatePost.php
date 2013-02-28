<?php

namespace SxBlog\Form;

use Zend\Form\Form;
use Zend\Form\Element\Csrf;
use Zend\ServiceManager\ServiceManager;

class CreatePost extends Form
{

    public function __construct(ServiceManager $serviceManager)
    {
        parent::__construct('create-post-form');

        $postFieldset = new Fieldset\Post($serviceManager);
        
        $postFieldset->setUseAsBaseFieldset(true);
        $this->add($postFieldset);
        
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
