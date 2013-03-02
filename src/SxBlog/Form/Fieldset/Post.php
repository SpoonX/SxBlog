<?php

namespace SxBlog\Form\Fieldset;

use Zend\Form\Fieldset;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\ServiceManager\ServiceManager;

class Post extends Fieldset implements InputFilterProviderInterface
{

    public function __construct(ServiceManager $serviceManager)
    {
        parent::__construct('post');

        $this->setHydrator(new DoctrineHydrator($serviceManager->get('Doctrine\ORM\EntityManager'), 'SxBlog\Entity\Post'));

        $this->add(array(
            'name'       => 'title',
            'options'    => array(
                'label' => 'Title',
            ),
            'attributes' => array(
                'required' => 'required',
            ),
        ));

        $this->add(array(
            'type' => 'DoctrineModule\Form\Element\ObjectMultiCheckbox',
            'name' => 'categories',
            'options' => array(
                'object_manager' => $serviceManager->get('Doctrine\ORM\EntityManager'),
                'target_class'   => 'SxBlog\Entity\Category',
                'property'       => 'name',
            ),
        ));

        $this->add(array(
            'name'       => 'slug',
            'options'    => array(
                'label' => 'Slug',
            ),
            'attributes' => array(
                'required' => 'required',
            ),
        ));

        $this->add(array(
            'name'       => 'body',
            'type'  => 'Zend\Form\Element\Textarea',
            'options'    => array(
                'label' => 'Body',
            ),
            'attributes' => array(
                'required' => 'required',
            ),
        ));
    }

    /**
     * @return array
     */
    public function getInputFilterSpecification()
    {
        return array(
            'title' => array(
                'required' => true,
            ),
            'slug' => array(
                'required' => true,
            ),
            'body' => array(
                'required' => true,
            ),
        );
    }

}
