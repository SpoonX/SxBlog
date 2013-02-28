<?php

namespace SxBlog\Form\Fieldset;

use Zend\Form\Fieldset;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\ServiceManager\ServiceManager;

class Category extends Fieldset implements InputFilterProviderInterface
{

    public function __construct(ServiceManager $serviceManager)
    {
        parent::__construct('category');

        $this->setHydrator(new DoctrineHydrator($serviceManager->get('Doctrine\ORM\EntityManager'), 'SxBlog\Entity\Category'));

        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'id'
        ));

        $this->add(array(
            'name'       => 'name',
            'options'    => array(
                'label' => 'Name'
            ),
            'attributes' => array(
                'required' => 'required'
            )
        ));

        $this->add(array(
            'name'       => 'slug',
            'options'    => array(
                'label' => 'Slug',
            ),
            'attributes' => array(
                'required' => 'required'
            )
        ));
    }

    /**
     * @return array
     */
    public function getInputFilterSpecification()
    {
        return array(
            'name' => array(
                'required' => true,
            ),
            'slug' => array(
                'required' => true,
            ),
        );
    }

}
