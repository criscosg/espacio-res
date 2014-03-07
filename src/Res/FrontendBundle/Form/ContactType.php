<?php

namespace Res\FrontendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text', array('required' => true))
        		->add('email', 'email', array('required' => true))
        		->add('message', 'textarea');
    }

    public function getName()
    {
        return 'contact_type';
    }
}
