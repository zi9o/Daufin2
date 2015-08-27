<?php

namespace Com\DaufinBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ContTablePrixType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('valeur',null,array('attr'=>array('class'=>'form-control parsley-validated')))
            ->add('tva',null,array('attr'=>array('class'=>'form-control parsley-validated')))
            ->add('idContart',null,array('attr'=>array('class'=>'form-control parsley-validated')))
            ->add('idRub',null,array('attr'=>array('class'=>'form-control parsley-validated')))
            ->add('idTVal',null,array('attr'=>array('class'=>'form-control parsley-validated')))
            ->add('idSTrajet',null,array('attr'=>array('class'=>'form-control parsley-validated')))
            ->add('dateOuverture',null,array('label'=>'Date Activation','attr'=>array('class'=>'form-control parsley-validated')))
            ->add('dateFermeture',null,array('label'=>'Date Desactivation','attr'=>array('class'=>'form-control parsley-validated')))
            ->add('etat','choice',array('choices' => array(
            		'Activee'   => 'Activee',
            		'Desactivee' => 'Desactivee',
            ),'label'=>'Etat du Taxe','attr'=>array('class'=>'form-control parsley-validated')))
            ->add('valeurMax',null,array('label'=>'Valeur Max','attr'=>array('class'=>'form-control parsley-validated')))
            ->add('valeurMin',null,array('label'=>'Valeur Min','attr'=>array('class'=>'form-control parsley-validated')))
            
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Com\DaufinBundle\Entity\ContTablePrix'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'com_daufinbundle_conttableprix';
    }
}
