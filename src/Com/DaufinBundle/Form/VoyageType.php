<?php

namespace Com\DaufinBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class VoyageType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('datePlanif',null,array('label'=>'Date de Planification','data'=>new \DateTime('now'),'attr'=>array('class'=>'form-control parsley-validated')))
            ->add('etatVoyage',
                  'choice',array('label'=>'Etat de Voyage',
                                 'choices' => array('Planification'=>'Planification',
                                                    'Validation'=>'Validation',
                                                    'EnRoute'=>'En Route',
                                                    'Arrivage'=>'Arrivage'),
                  'attr'=>array('class'=>'form-control parsley-validated')))
            ->add('dateValid',null,array('label'=>'Date de Validation','attr'=>array('class'=>'form-control parsley-validated')))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Com\DaufinBundle\Entity\Voyage'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'com_daufinbundle_voyage';
    }
}
