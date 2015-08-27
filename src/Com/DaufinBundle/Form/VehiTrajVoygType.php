<?php

namespace Com\DaufinBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class VehiTrajVoygType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('datePasser',null,array('label'=>"Date d'Affectation",'attr'=>array('class'=>'form-control parsley-validated')))
            /*->add('voyage1',null,array('label'=>"Voyage",'attr'=>array('class'=>'form-control parsley-validated')))*/           
            ->add('trajet',null,array('label'=>'Trajet','attr'=>array('class'=>'form-control parsley-validated')))
            ->add('vehicule',null,array('label'=>'Vehicule','attr'=>array('class'=>'form-control parsley-validated')))
            ->add('voyage',new VoyageType())            
            ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Com\DaufinBundle\Entity\VehiTrajVoyg',
            'cascade_validation'=>true,
            'validation_groups' => array('yourValidationGroup')
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'com_daufinbundle_vehitrajvoyg';
    }
}
