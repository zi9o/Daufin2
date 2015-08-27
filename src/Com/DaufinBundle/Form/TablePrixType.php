<?php

namespace Com\DaufinBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TablePrixType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('sTrajet',null,array('label'=>'Sous Trajet','attr'=>array('class'=>'form-control parsley-validated')))
            ->add('rub',null,array('label'=>'Rubrique','attr'=>array('class'=>'form-control parsley-validated')))
            ->add('idTVal',null,array('label'=>'Type de Valorisation','attr'=>array('class'=>'form-control parsley-validated')))
            ->add('valeurMax',null,array('label'=>'Valeur Max','attr'=>array('class'=>'form-control parsley-validated')))
            ->add('valeurMin',null,array('label'=>'Valeur Min','attr'=>array('class'=>'form-control parsley-validated')))
            ->add('tva',null,array('label'=>'TVA','attr'=>array('class'=>'form-control parsley-validated'))) 
            ->add('valeur',null,array('label'=>'Valeur','attr'=>array('class'=>'form-control parsley-validated')))
            ->add('dateOuverture',null,array('label'=>'Date Activation','data'=>new \DateTime('now'),'attr'=>array('class'=>'form-control parsley-validated')))
            ->add('dateFermeture',null,array('label'=>'Date Desactivation','data'=>new \DateTime('2020-06-16 18:00:00'),'attr'=>array('class'=>'form-control parsley-validated')))
            ->add('etat','choice',array('choices' => array(
						        	'Activee'   => 'Activee',
						        	'Desactivee' => 'Desactivee',
						    ),'label'=>'Etat du Taxe','attr'=>array('class'=>'form-control parsley-validated')))
            
            
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Com\DaufinBundle\Entity\TablePrix'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'com_daufinbundle_tableprix';
    }
}
