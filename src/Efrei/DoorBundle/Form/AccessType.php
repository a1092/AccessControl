<?php

namespace Efrei\DoorBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AccessType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fromdate')
            ->add('todate')
            ->add('fromtime')
            ->add('totime')
            ->add('door')
            ->add('card')
            ->add('group')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Efrei\DoorBundle\Entity\Access'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'efrei_doorbundle_access';
    }
}
