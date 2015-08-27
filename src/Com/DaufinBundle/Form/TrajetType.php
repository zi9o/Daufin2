<?php

namespace Com\DaufinBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TrajetType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('codeTrajet',null,array('label'=>'Code Trajet','attr'=>array('class'=>'form-control parsley-validated')))
            ->add('libelleTrajet',null,array('label'=>'Libelle Trajet','attr'=>array('class'=>'form-control parsley-validated')))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Com\DaufinBundle\Entity\Trajet'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'com_daufinbundle_trajet';
    }
}
