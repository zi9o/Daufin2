<?php

namespace Com\DaufinBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AgenceType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('codeAgence',null,array('label'=>'Code Agence','attr'=>array('class'=>'form-control parsley-validated')))
            ->add('libelleAg',null,array('label'=>'Libelle','attr'=>array('class'=>'form-control parsley-validated')))
            ->add('typeAgence','choice',array('label'=>'Type','attr'=>array('class'=>'form-control parsley-validated'),
                                 'choices' => array('livraison'=>'Livraison',
                                                    'entrepot'=>'Entrepot',
                                 					'ramassage'=>'Ramassage')))
            ->add('telAg',null,array('label'=>'Téléphone','attr'=>array('class'=>'form-control parsley-validated')))
            ->add('faxAg',null,array('label'=>'Fax','attr'=>array('class'=>'form-control parsley-validated')))
            ->add('adresseAg',null,array('label'=>'Adresse','attr'=>array('class'=>'form-control parsley-validated')))
            ->add('ville','entity',array('label'=>'Ville','attr'=>array('class'=>'form-control parsley-validated'),'class' => 'Com\DaufinBundle\Entity\Ville' ,'label'=>'Ville',
        				'placeholder' => '--SELECTIONNER--'))
          //  ->add('caisse',new CaisseType())
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Com\DaufinBundle\Entity\Agence'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'com_daufinbundle_agence';
    }
}
