<?php

namespace Com\UserBundle\Admin;

use Sonata\UserBundle\Admin\Entity\UserAdmin as BaseAdmin;

class UserAdmin extends BaseAdmin
{

    /**
     * {@inheritdoc}
     */
    protected $baseRoutePattern = 'utilisateurs';
    
    protected function configureFormFields(\Sonata\AdminBundle\Form\FormMapper $formMapper)
    {
    	parent::configureFormFields($formMapper);
    
    	//$formMapper->
    	$formMapper
    	->with('General')
    	->add('personnel', null, array(  			 
    			'required' => true,
    			'expanded' => false,
    			'multiple' => false,
    			'label' => 'choisir un personnel',
    			'class' => 'ComDaufinBundle:Personnel'
    	))
    
    	->end();
    }
}