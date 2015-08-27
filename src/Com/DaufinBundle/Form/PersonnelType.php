<?php

namespace Com\DaufinBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PersonnelType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('matriculePers',null,array('label'=>'Matricule','attr'=>array('class'=>'form-control parsley-validated')))
            ->add('nomPers',null,array('label'=>'Nom','attr'=>array('class'=>'form-control parsley-validated')))
            ->add('prenomPers',null,array('label'=>'Prénom','attr'=>array('class'=>'form-control parsley-validated')))
            ->add('fonction',null,array('label'=>'Fonction','attr'=>array('class'=>'form-control parsley-validated')))
            ->add('telPers',null,array('label'=>'Téléphone','attr'=>array('class'=>'form-control parsley-validated')))
            ->add('gsmPers',null,array('label'=>'GSM','attr'=>array('class'=>'form-control parsley-validated')))
            ->add('cinPers',null,array('label'=>'C.I.N','attr'=>array('class'=>'form-control parsley-validated')))
            ->add('dateDebut',null,array('label'=>'Date de Début','attr'=>array('class'=>'form-control parsley-validated')))
            ->add('etatActivitee',null,array('label'=>"Etat d'activité",'attr'=>array('class'=>'form-control parsley-validated')))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Com\DaufinBundle\Entity\Personnel'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'com_daufinbundle_personnel';
    }
}
