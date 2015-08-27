<?php

namespace Com\DaufinBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UniteManuType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('typeUnite',null,array('attr'=>array('class'=>'form-control parsley-validated')))
            ->add('poidsUnite',null,array('attr'=>array('class'=>'form-control parsley-validated')))
            ->add('volumeUnite',null,array('attr'=>array('class'=>'form-control parsley-validated')))
            ->add('nbrColisPlt',null,array('attr'=>array('class'=>'form-control parsley-validated')))
            ->add('exept',null,array('attr'=>array('class'=>'form-control parsley-validated')))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Com\DaufinBundle\Entity\UniteManu'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'com_daufinbundle_unitemanu';
    }
}
