<?php

namespace Com\DaufinBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MouvementCaisseType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('typeMouvement','choice',array('label'=>'Type Mouvement','attr'=>array('class'=>'form-control parsley-validated'),
                                 'choices' => array('Retrait'=>'Retrait',
                                                    'Versement'=>'Versement')))
            ->add('libelleMouvement',null,array('label'=>'Code Agence','attr'=>array('class'=>'form-control parsley-validated')))
            //->add('dateMouvement')
            ->add('valeur',null,array('label'=>'Code Agence','attr'=>array('class'=>'form-control parsley-validated')))
            //->add('agence')
           // ->add('personnel')
            ->add('caisse','entity',array(
            		                      'label'=>'Code Agence',
            		                      'class' => 'Com\DaufinBundle\Entity\Caisse' ,
            		                      'label'=>'Ville',
        				                  'placeholder' => '--SELECTIONNER--',
            		                      'attr'=>array(
            		                       		        'class'=>'form-control parsley-validated'
            		                      		
            		                      )))
            ->add('expedition','entity',array('label'=>'Code Agence','class' => 'Com\DaufinBundle\Entity\Expedition' ,'label'=>'Ville',
        				'placeholder' => '--SELECTIONNER--','attr'=>array('class'=>'form-control parsley-validated'),
            		'required' => false,
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Com\DaufinBundle\Entity\MouvementCaisse'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'com_daufinbundle_mouvementcaisse';
    }
}
