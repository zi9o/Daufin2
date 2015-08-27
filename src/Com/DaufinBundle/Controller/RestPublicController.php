<?php

namespace Com\DaufinBundle\Controller;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Com\DaufinBundle\Entity\Agence;
use Symfony\Component\HttpFoundation\Response;
use Com\DaufinBundle\Entity\Expedition;
use FOS\RestBundle\Controller\Annotations\Get;

class RestPublicController  extends FOSRestController {
	
	
	/**
	 * Lists all Agence entities.
	 *
	 *  
	 */
	public function getAllAgencesAction( ){
		
		 $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ComDaufinBundle:Agence')->findAll();

        $response = array("agences" =>  $entities,);
        
        
        return $response;
	}
	
	/**
	 * Lists all Agence entities.
	 *
	 *  @Route("/getExpeditionByCodeDeclaration", defaults={"_format" = "json"})
	 *  @Get("/getExpeditionByCodeDeclaration/{codeDeclaration}/")
	 */
	public function getExpeditionByCodeDeclarationAction($codeDeclaration){
	
		$em = $this->getDoctrine()->getManager();
	
		$entitie = $em->getRepository('ComDaufinBundle:Expedition')->findByCodeDeclaration($codeDeclaration);
	
		return $entitie;
	}
	
}