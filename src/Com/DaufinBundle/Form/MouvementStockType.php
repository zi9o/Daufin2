<?php

namespace Com\DaufinBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MouvementStockType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateMouv',null,array('label'=>'Date Mouvement','attr'=>array('class'=>'form-control parsley-validated')))
            ->add('agence',null,array('label'=>'Agence','attr'=>array('class'=>'form-control parsley-validated')))
            ->add('uniteManu',null,array('label'=>'Unite Manutention','attr'=>array('class'=>'form-control parsley-validated')))
            ->add('personnel',null,array('label'=>'Personnel','attr'=>array('class'=>'form-control parsley-validated')))
            ->add('mouvement',null,array('label'=>'Mouvement','attr'=>array('class'=>'form-control parsley-validated')))
                ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Com\DaufinBundle\Entity\MouvementStock'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'com_daufinbundle_mouvementstock';
    }
}
