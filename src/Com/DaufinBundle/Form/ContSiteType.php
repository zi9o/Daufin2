<?php

namespace Com\DaufinBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ContSiteType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('typeSite',null,array('attr'=>array('class'=>'form-control parsley-validated')))
            ->add('contart',null,array('attr'=>array('class'=>'form-control parsley-validated')))
            ->add('site',null,array('attr'=>array('class'=>'form-control parsley-validated')))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Com\DaufinBundle\Entity\ContSite'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'com_daufinbundle_contsite';
    }
}
