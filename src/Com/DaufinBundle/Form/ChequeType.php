<?php

namespace Com\DaufinBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ChequeType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('numCheque',null,array('attr'=>array('class'=>'form-control parsley-validated')))
            ->add('titreCheque',null,array('attr'=>array('class'=>'form-control parsley-validated')))
            ->add('montantChq',null,array('attr'=>array('class'=>'form-control parsley-validated')))
            ->add('dateEcheance',null,array('attr'=>array('class'=>'form-control parsley-validated')))
            ->add('natureCheque',null,array('attr'=>array('class'=>'form-control parsley-validated')))
            ->add('etatCheque',null,array('attr'=>array('class'=>'form-control parsley-validated')))
            ->add('exept',null,array('attr'=>array('class'=>'form-control parsley-validated')))
            ->add('facture',null,array('attr'=>array('class'=>'form-control parsley-validated')))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Com\DaufinBundle\Entity\Cheque'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'com_daufinbundle_cheque';
    }
}
