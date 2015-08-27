<?php

namespace Com\DaufinBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CaisseType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('typeCaisse','choice',array('label'=>'Code Agence','attr'=>array('class'=>'form-control parsley-validated'),
                                 'choices' => array('espece'=>'Espéce',
                                                    'banque'=>'Banque')))
            ->add('libelleCaisse',null,array('label'=>'Code Agence','attr'=>array('class'=>'form-control parsley-validated')))
        //    ->add('dateDebut',null,array('label'=>'Code Agence','attr'=>array('class'=>'form-control parsley-validated')))
            ->add('soldeCaisse',null,array('label'=>'Code Agence','attr'=>array('class'=>'form-control parsley-validated')))
            ->add('categorieCaisse','choice', array(
						    'choices' => array(
						        	'Service'   => 'Service',
						        	'Depense' => 'Dépense',
						    ),
						    'multiple' => false,
        					'required' => true,
        			        'label'=>'Mode',
	        			    'placeholder' => '--SELECTIONNER--'
						   ))
         //   ->add('agence')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Com\DaufinBundle\Entity\Caisse'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'com_daufinbundle_caisse';
    }
}
