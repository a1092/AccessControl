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
            ->add('fromdate',    'datetime', array(
				'required' => false,
				'empty_value' => ''
			))
			->add('todate',    'datetime', array(
				'required' => false,
				'empty_value' => ''
			))
			->add('fromtime', 'time', array(
				'required' => false,
				'empty_value' => ''
			))
			->add('totime', 'time', array(
				'required' => false,
				'empty_value' => ''
			));
		
		
		if($options["data"]->getDoor() != null) {
			
			$builder->add('card', 'entity', array(
				'class' => 'Efrei\DoorBundle\Entity\Card',
				'required' => false,
				'empty_value' => ''
			));
			
			$builder->add('group', 'entity', array(
				'class' => 'Efrei\DoorBundle\Entity\CardGroup',
				'required' => false,
				'empty_value' => ''
			));
			
		} else if($options["data"]->getCard() != null) {
			$builder->add('door', 'entity', array(
				'class' => 'Efrei\DoorBundle\Entity\Door',
				'required' => true,
				'empty_value' => ''
			));
		}
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
