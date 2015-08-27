<?php

namespace Com\DaufinBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class OpererOrdreType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateOperation',null,array('attr'=>array('class'=>'form-control parsley-validated')))
            ->add('personnel',null,array('attr'=>array('class'=>'form-control parsley-validated')))
            ->add('ordreLvRm',null,array('attr'=>array('class'=>'form-control parsley-validated')))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Com\DaufinBundle\Entity\OpererOrdre'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'com_daufinbundle_opererordre';
    }
}
