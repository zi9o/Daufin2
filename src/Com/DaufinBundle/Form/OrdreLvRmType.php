<?php

namespace Com\DaufinBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class OrdreLvRmType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateCreation',null,array('attr'=>array('class'=>'form-control parsley-validated')))
            ->add('typeOrdre',null,array('attr'=>array('class'=>'form-control parsley-validated')))
            ->add('dateLivraison',null,array('attr'=>array('class'=>'form-control parsley-validated')))
            ->add('ordreLivraison',null,array('attr'=>array('class'=>'form-control parsley-validated')))
            ->add('secteur',null,array('attr'=>array('class'=>'form-control parsley-validated')))
            ->add('vehicule',null,array('attr'=>array('class'=>'form-control parsley-validated')))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Com\DaufinBundle\Entity\OrdreLvRm'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'com_daufinbundle_ordrelvrm';
    }
}
