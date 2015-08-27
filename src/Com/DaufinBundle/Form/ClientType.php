<?php

namespace Com\DaufinBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ClientType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('codeClient',null,array('label'=>'Code Client','attr'=>array('class'=>'form-control parsley-validated')))
            ->add('telClt',null,array('label'=>'Telephone','attr'=>array('class'=>'form-control parsley-validated')))
            ->add('faxClt',null,array('label'=>'Fax','attr'=>array('class'=>'form-control parsley-validated')))
            ->add('contact',null,array('label'=>'Contact','attr'=>array('class'=>'form-control parsley-validated')))
            ->add('adresseClt',null,array('label'=>'Adresse','attr'=>array('class'=>'form-control parsley-validated')))
            ->add('rSociale',null,array('label'=>'Raison Sociale','attr'=>array('class'=>'form-control parsley-validated')))
            ->add('patente',null,array('label'=>'Patente','attr'=>array('class'=>'form-control parsley-validated')))
            ->add('rCommerce',null,array('label'=>'Registre Commerce','attr'=>array('class'=>'form-control parsley-validated')))
            ->add('idFiscale',null,array('label'=>'Identifiant Fiscale','attr'=>array('class'=>'form-control parsley-validated')))
            ->add('dirGeneral',null,array('label'=>'Directeur General','attr'=>array('class'=>'form-control parsley-validated')))
            ->add('dirFinancier',null,array('label'=>'Directeur Financier','attr'=>array('class'=>'form-control parsley-validated')))
            ->add('nomPart',null,array('label'=>'Nom Particulier','attr'=>array('class'=>'form-control parsley-validated')))
            ->add('prenomPart',null,array('label'=>'Prenom Particulier','attr'=>array('class'=>'form-control parsley-validated')))
            ->add('cinPer',null,array('label'=>'C.I.N Particulier','attr'=>array('class'=>'form-control parsley-validated')))
            ->add('secteur',null,array('label'=>'Secteur','attr'=>array('class'=>'form-control parsley-validated')))
            ->add('typeClient',
                  'choice',array('label'=>'Type Client',
                                 'choices' => array('Particulier'=>'Particulier',
                                                    'Compte'=>'Compte'),
                                 'attr'=>array('class'=>'form-control parsley-validated')))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Com\DaufinBundle\Entity\Client'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'com_daufinbundle_client';
    }
}
