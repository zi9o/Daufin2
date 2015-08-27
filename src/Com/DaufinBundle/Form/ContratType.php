<?php

namespace Com\DaufinBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ContratType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateOuvert',null,array('attr'=>array('class'=>'form-control parsley-validated')))
            ->add('dateFermeture',null,array('attr'=>array('class'=>'form-control parsley-validated')))
            ->add('mPaiment',null,array('attr'=>array('class'=>'form-control parsley-validated')))
            ->add('etatContart',null,array('attr'=>array('class'=>'form-control parsley-validated')))
            ->add('client',null,array('attr'=>array('class'=>'form-control parsley-validated')))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Com\DaufinBundle\Entity\Contrat'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'com_daufinbundle_contrat';
    }
}
