<?php

namespace Com\DaufinBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SousTrajetType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('codeSousTrajet',null,array('label'=>'Code Sous Trajet','attr'=>array('class'=>'form-control parsley-validated')))
            ->add('villeArrivee',null,array('label'=>"Ville d'Arrivé",'attr'=>array('class'=>'form-control parsley-validated')))
            ->add('villeDepart',null,array('label'=>"Ville de Départ",'attr'=>array('class'=>'form-control parsley-validated')))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Com\DaufinBundle\Entity\SousTrajet'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'com_daufinbundle_soustrajet';
    }
}
