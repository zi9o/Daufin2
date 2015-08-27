<?php

namespace Com\DaufinBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ExpeditionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('envDate',null,array('attr'=>array('class'=>'form-control parsley-validated')))
            ->add('envRemarque',null,array('attr'=>array('class'=>'form-control parsley-validated')))
            ->add('recDate',null,array('attr'=>array('class'=>'form-control parsley-validated')))
            ->add('recRemarque',null,array('attr'=>array('class'=>'form-control parsley-validated')))
            ->add('poidsExp',null,array('attr'=>array('class'=>'form-control parsley-validated')))
            ->add('volumeExp',null,array('attr'=>array('class'=>'form-control parsley-validated')))
            ->add('nbrColis',null,array('attr'=>array('class'=>'form-control parsley-validated')))
            ->add('nbrPalets',null,array('attr'=>array('class'=>'form-control parsley-validated')))
            ->add('dateDecl',null,array('attr'=>array('class'=>'form-control parsley-validated')))
            ->add('mdPort',null,array('attr'=>array('class'=>'form-control parsley-validated')))
            ->add('expVal',null,array('attr'=>array('class'=>'form-control parsley-validated')))
            ->add('etatExp',null,array('attr'=>array('class'=>'form-control parsley-validated')))
            ->add('totalMontant',null,array('attr'=>array('class'=>'form-control parsley-validated')))
            ->add('taxType',null,array('attr'=>array('class'=>'form-control parsley-validated')))
            ->add('modeRegl',null,array('attr'=>array('class'=>'form-control parsley-validated')))
            ->add('etatRegl',null,array('attr'=>array('class'=>'form-control parsley-validated')))
            ->add('dateReglement',null,array('attr'=>array('class'=>'form-control parsley-validated')))
            ->add('envClient',null,array('attr'=>array('class'=>'form-control parsley-validated')))
            ->add('envVille',null,array('attr'=>array('class'=>'form-control parsley-validated')))
            ->add('recClient',null,array('attr'=>array('class'=>'form-control parsley-validated')))
            ->add('recVille',null,array('attr'=>array('class'=>'form-control parsley-validated')))
            ->add('expTransp',null,array('attr'=>array('class'=>'form-control parsley-validated')))
            ->add('facture',null,array('attr'=>array('class'=>'form-control parsley-validated')))
            ->add('clientReglee',null,array('attr'=>array('class'=>'form-control parsley-validated')))
            ->add('ordreLv',null,array('attr'=>array('class'=>'form-control parsley-validated')))
            ->add('lvDate',null,array('attr'=>array('class'=>'form-control parsley-validated')))
            ->add('lvRemarque',null,array('attr'=>array('class'=>'form-control parsley-validated')))
            ->add('typeLivraison',null,array('attr'=>array('class'=>'form-control parsley-validated')))
            ->add('recSite',null,array('attr'=>array('class'=>'form-control parsley-validated')))
            ->add('envSite',null,array('attr'=>array('class'=>'form-control parsley-validated')))
            ->add('envSecteur',null,array('attr'=>array('class'=>'form-control parsley-validated')))
            ->add('envAgence',null,array('attr'=>array('class'=>'form-control parsley-validated')))
            ->add('recSite',null,array('attr'=>array('class'=>'form-control parsley-validated')))
            ->add('recAgence',null,array('attr'=>array('class'=>'form-control parsley-validated')))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Com\DaufinBundle\Entity\Expedition'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'com_daufinbundle_expedition';
    }
}
