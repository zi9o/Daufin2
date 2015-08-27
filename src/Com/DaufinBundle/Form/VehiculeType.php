<?php

namespace Com\DaufinBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class VehiculeType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('matriculeVeh',null,array('label'=>'Matricule','attr'=>array('class'=>'form-control parsley-validated')))
            ->add('marqueVeh',null,array('label'=>'Marque','attr'=>array('class'=>'form-control parsley-validated')))
            ->add('modelVeh',null,array('label'=>'Model','attr'=>array('class'=>'form-control parsley-validated')))
            ->add('typeVehicule',null,array('label'=>'Type','attr'=>array('class'=>'form-control parsley-validated')))
            ->add('poidsVide',null,array('label'=>'Poids vide','attr'=>array('class'=>'form-control parsley-validated')))
            ->add('poidsPlein',null,array('label'=>'Poids en Plien','attr'=>array('class'=>'form-control parsley-validated')))
           // ->add('voyage',null,array('label'=>'Voyage','attr'=>array('class'=>'form-control parsley-validated')))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Com\DaufinBundle\Entity\Vehicule'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'com_daufinbundle_vehicule';
    }
}
