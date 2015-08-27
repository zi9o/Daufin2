<?php

namespace Com\DaufinBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TrajetSTrajetType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('rangeRet',null,array('label'=>'Range','attr'=>array('class'=>'form-control parsley-validated')))
            ->add('sousTrajet',null,array('label'=>'Sous Trajet','attr'=>array('class'=>'form-control parsley-validated')))
            ->add('trajet',null,array('label'=>'Trajet','attr'=>array('class'=>'form-control parsley-validated')))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Com\DaufinBundle\Entity\TrajetSTrajet'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'com_daufinbundle_trajetstrajet';
    }
}
