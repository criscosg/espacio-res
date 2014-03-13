<?php
namespace Res\EventBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', 'text', array('required' => true))
                ->add('description', 'textarea', array('required' => true))
                ->add('date', 'date', array('widget' => 'single_text', 'required' => true, 'format' => 'dd-MM-yyyy'));
    }

    public function getDefaultOptions(array $options)
    {
        return array(
                'data_class' => 'Res\EventBundle\Entity\Event',
        );
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
                'data_class' => 'Res\EventBundle\Entity\Event'
        ));
    }

    public function getName()
    {
        return 'event_type';
    }
}