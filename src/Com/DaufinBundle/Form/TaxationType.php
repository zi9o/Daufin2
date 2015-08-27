<?php

namespace Com\DaufinBundle\Form;

use Symfony\Component\Form\AbstractType;
use Com\DaufinBundle\Form\PersonnelType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Com\DaufinBundle\Entity\Client;
use Doctrine\DBAL\Types\StringType;
use Doctrine\ORM\EntityRepository;
use Proxies\__CG__\Com\DaufinBundle\Entity\Personnel;
use Com\DaufinBundle\Entity\Expedition;

class TaxationType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    	$date = new \DateTime();
    	$dateNow = $date->format('Y-m-d H:i:s');
    	
        $builder->add('ramasseur','entity', array(
            		  'class' => 'Com\DaufinBundle\Entity\Personnel','label'=>'Ramasseur',
               		  'query_builder' => function (EntityRepository $repository)
                             {
                                 return $repository->createQueryBuilder('p')
                                        ->where("p.fonction like '%Ramasseur%'");
                             },
        				'placeholder' => '--SELECTIONNER--'))
               ->add('receptionneur','entity', array(
           			 'class' => 'Com\DaufinBundle\Entity\Personnel','label'=>'Réceptionneur',
               		  'query_builder' => function (EntityRepository $repository)
                             {
                                 return $repository->createQueryBuilder('p')
                                        ->where("p.fonction like '%Ramasseur%'");
                             },
        				'placeholder' => '--SELECTIONNER--'))
               ->add('destinataire','entity', array(
             		 'class' => 'Com\DaufinBundle\Entity\Client' ,'label'=>'Num Compte',
               		  'query_builder' => function (EntityRepository $repository)
                             {
                                 return $repository->createQueryBuilder('c')
                                        ->where("c.typeClient = 'Compte'");
                             }))
//             	->add('siteExp','entity', array(
//             		 'class' => 'Com\DaufinBundle\Entity\Site' ,'label'=>'Client(Site)'))
//             	->add('siteDest','entity', array(
//             		 		'class' => 'Com\DaufinBundle\Entity\Site' ,'label'=>'Client(Site)'))
               ->add('expediteur','entity', array(
            		 'class' => 'Com\DaufinBundle\Entity\Client' ,'label'=>'Num Compte',
               		  'query_builder' => function (EntityRepository $repository)
                             {
                                 return $repository->createQueryBuilder('c')
                                        ->where("c.typeClient = 'Compte'");
                             }))
                ->add('villeExpediteur','entity', array(
            		 	'class' => 'Com\DaufinBundle\Entity\Ville' ,'label'=>'Ville',
        				'placeholder' => '--SELECTIONNER--'))
                ->add('villeDestinataire','entity', array(
            		 	'class' => 'Com\DaufinBundle\Entity\Ville' ,'label'=>'Ville',
        				'placeholder' => '--SELECTIONNER--'))
	        	->add('modeExp', 'choice', array(
						    'choices' => array(
						        	'portPaye'   => 'Port Payé ',
						        	'portDu' => 'Port Dû',
						    ),
						    'multiple' => false,
        					'required' => true,
        			        'label'=>'Mode',
	        			    'placeholder' => '--SELECTIONNER--'
						   ))
    	    	->add('typeExp', 'choice', array(
						    'choices' => array(
						        	'normal'   => 'Normal',
						        	'express' => 'Express',
						    ),
						    'multiple' => false,
        					'required' => true,
						'label'=>'Type',
        				'placeholder' => '--SELECTIONNER--'))
        		->add('natureExp', 'checkbox', array(
				    'label'     => 'Fragile',
				    'required'  => false,
				))
        	->add('nbreColis','text',array('label'=>'Nombre de Colis'))
        	->add('poids','text',array('label'=>'Poids'))
        	//->add('telDestinataire','text',array('label'=>'Tél'))      	 
        	//->add('telExpediteur','text',array('label'=>'Tél')) 
        	//->add('adresseDestinataire','text',array('label'=>'Adresse'))
        	//->add('adresseExpediteur','text',array('label'=>'Adresse'))
        	->add('volume','text',array('label'=>'Volume','required' => false))
        	->add('nbrePalettes','text',array('label'=>'Nombre de Palettes'))
        	->add('typeLivraison', 'choice', array(
						    		'choices' => array(
							        	'domicile'   => 'A domicile',
							        	'gare' => 'En gare',
						   			 ),
						   			 'multiple' => false,
        							 'required' => true,
        			                 'label'=>'Type de Livraison',
        							 'placeholder' => '--SELECTIONNER--'
						))
        	->add('remarque','textarea',array('label'=>'Remarque','required' => false,'attr' => array('cols' => '40', 'rows' => '1'),))
            ->add('crbt','text',array('label'=>'C/Remoboursement'))
        	->add('cheque','text',array('label'=>'C/Chéque'))
        	->add('montant','text',array('read_only' =>true, 'required'    => true))
        	->add('traite','text',array('label'=>'C/Traite'))
        	->add('codeDeclaration','text',array('label'=>'Code Déclaration','required' => true))
        	->add('cBonLivr','text',array('label'=>'Retour Bon Livraison'))
        	->add('valeurDecl','text',array('label'=>'Valeur Déclarée'))
        	//->add('agenceDepart','text',array('label'=>'Agence Depart','data' =>'1','read_only' => 'readOnly'))
        	->add('agenceTransit','entity', array(
            		 	'class' => 'Com\DaufinBundle\Entity\Agence','label'=>'Agence Transite',
        				'multiple' => false,
        				'required' => false,
        				'label'=>'Type de Livraison',
        				'placeholder' => '--Pas de Transit--'
        	))
        	->add('dateDeclaration','text',array('label'=>'Date & Heure','data' =>$dateNow,'read_only' => 'readOnly'));
               
      //  $this->widgetSchema['title']->setAttribute("dateDecl","hidden");
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Com\DaufinBundle\Entity\Taxation',
        	 'attr' => array(
        				'class' => 'form-horizontal',
        	 			'role'=>'form',
        		),
        		
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'com_daufinbundle_taxation';
    }
}
