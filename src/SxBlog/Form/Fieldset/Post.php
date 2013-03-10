<?php

namespace SxBlog\Form\Fieldset;

use Zend\Form\Fieldset;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Doctrine\Common\Persistence\ObjectManager;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\ServiceManager\ServiceManager;

class Post extends Fieldset implements InputFilterProviderInterface
{

    public function __construct(ObjectManager $objectManager)
    {
        parent::__construct('post');

        $this->setHydrator(new DoctrineHydrator($objectManager , 'SxBlog\Entity\Post'));

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
            'type'    => 'DoctrineModule\Form\Element\ObjectMultiCheckbox',
            'name'    => 'categories',
            'options' => array(
                'object_manager' => $objectManager,
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
            'name'       => 'excerpt',
            'type'       => 'Zend\Form\Element\Textarea',
            'options'    => array(
                'label' => 'Excerpt',
            ),
        ));

        $this->add(array(
            'name'       => 'body',
            'type'       => 'Zend\Form\Element\Textarea',
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
            'slug'  => array(
                'required' => true,
            ),
            'body'  => array(
                'required' => true,
            ),
        );
    }

}
