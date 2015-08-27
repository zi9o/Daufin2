<?php

namespace Com\DaufinBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ReglementType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateReglement')
            ->add('dateCreation')
            ->add('totalMontantTTC')
            ->add('montantReglement')
            ->add('statutReglement')
            ->add('modeReglement')
            ->add('refReglement')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Com\DaufinBundle\Entity\Reglement'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'com_daufinbundle_reglement';
    }
}
