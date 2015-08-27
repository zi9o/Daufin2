<?php

namespace Com\DaufinBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class IncidentType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('typeIncident',null,array('label'=>'Type Incident','attr'=>array('class'=>'form-control parsley-validated')))
            ->add('dateIncident',null,array('label'=>'Date Incident','data' => new \DateTime(),'attr'=>array('class'=>'form-control parsley-validated')))
            ->add('description',null,array('label'=>'Description','attr'=>array('class'=>'form-control parsley-validated')))
            ->add('uniteManu',null,array('label'=>'Unite Manutention','attr'=>array('class'=>'form-control parsley-validated')))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Com\DaufinBundle\Entity\Incident'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'com_daufinbundle_incident';
    }
}
