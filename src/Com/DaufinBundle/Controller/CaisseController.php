<?php

namespace Com\DaufinBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;

use Com\DaufinBundle\Entity\Caisse;
use Com\DaufinBundle\Form\CaisseType;


use Symfony\Component\HttpFoundation\Response;
use Com\DaufinBundle\Entity\TablePrix;
use Com\DaufinBundle\Entity\Site;
use Com\DaufinBundle\Entity\Client;
use Com\DaufinBundle\Entity\Expedition;
use Com\DaufinBundle\Entity\ExpTransp;
use Com\DaufinBundle\Entity\Voyage;
use Com\DaufinBundle\Entity\Vehicule;
use Com\DaufinBundle\Entity\SousTrajet;
use Com\DaufinBundle\Entity\OpererExpedition;
use Com\DaufinBundle\Entity\OpererVoyage;
use Com\DaufinBundle\Entity\Personnel;
use Com\DaufinBundle\Entity\Secteur;
use Com\DaufinBundle\Entity\Agence;
use Com\DaufinBundle\Entity\Cheque;
use Com\DaufinBundle\Entity\Traite;
use Com\DaufinBundle\Entity\Crbt;
use Com\DaufinBundle\Entity\BLivraisonM;
use Com\DaufinBundle\Entity\SuivService;
use Com\DaufinBundle\Entity\MouvementCaisse;

/**
 * Caisse controller.
 *
 * @Route("/com_caisse")
 */
class CaisseController extends Controller
{

    /**
     * Lists all Caisse entities.
     *
     * @Route("/", name="com_caisse")
     * @Method("GET")
     * @Template()
     * @Secure(roles="ROLE_SHOW_ALL_CAISSE")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ComDaufinBundle:Caisse')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Caisse entity.
     *
     * @Route("/", name="com_caisse_create")
     * @Method("POST")
     * @Template("ComDaufinBundle:Caisse:new.html.twig")
     * @Secure(roles="ROLE_SHOW_ADD_CAISSE")
     */
    public function createAction(Request $request)
    {
        $entity = new Caisse();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('com_caisse_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }
    /**
     * Creates a new Caisse entity.
     *
     * @Route("/", name="com_caisse_create_caisse_agence")
     * @Method("POST")
     * @Template("ComDaufinBundle:MouvementCaisse:newCaisseAgence.html.twig")
     * @Secure(roles="ROLE_ADD_MOUVEMENT_CAISSE_AGENCE")
     */
    public function createCaisseAgenceAction(Request $request)
    {
    	$params = $this->getRequest()->request->all();
    	
    	$libelleMouvement=$params['libelleMouvement'];
    	$typeMouvement=$params['typeMouvement'];    	 
    	$valeur=$params['valeur'];   
    	
    	$idCaisee=$params['caisse'];
    	$idExpedition=$params['expedition'];    	 
    	$entity = new MouvementCaisse();

        $em = $this->getDoctrine()->getManager();
        
        $caisse=$em->getRepository('ComDaufinBundle:Caisse')->find($idCaisee);
        $expedition=$em->getRepository('ComDaufinBundle:Expedition')->find($idExpedition);
        
        $entity->setAgence($caisse->getAgence());
        $entity->setCaisse($caisse);
        $entity->setDateMouvement(new \DateTime());
        $entity->setLibelleMouvement($libelleMouvement);
        $entity->setValeur($valeur);
        $entity->setTypeMouvement($typeMouvement);
        $entity->setPersonnel($this->getUser()->getPersonnel());
        if($entity->getTypeMouvement()=='Retrait')
            $entity->getCaisse()->setSoldeCaisse($entity->getCaisse()->getSoldeCaisse()-$entity->getValeur());
        else  
        	$entity->getCaisse()->setSoldeCaisse($entity->getCaisse()->getSoldeCaisse()+$entity->getValeur());
    	
        if($expedition!=null)
        	$entity->setExpedition($expedition);
        
        $em->persist($entity);
        $em->flush();
       
    	//	return $this->redirect($this->generateUrl('com_caisse_show', array('id' => $caisse->getId())));
    	
        return $this->redirect($this->generateUrl('com_caisse_show_caisse_agence',array('categorie' => $caisse->getCategorieCaisse())));
     //   return $this->redirect($this->generateUrl('com_caisse'));
         
    }

    /**
     * Creates a form to create a Caisse entity.
     *
     * @param Caisse $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Caisse $entity)
    {
        $form = $this->createForm(new CaisseType(), $entity, array(
            'action' => $this->generateUrl('com_caisse_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Ajouter'));

        return $form;
    }

    /**
     * Displays a form to create a new Caisse entity.
     *
     * @Route("/new", name="com_caisse_new")
     * @Method("GET")
     * @Template()
     * @Secure(roles="ROLE_ADD_CAISSE")
     */
    public function newAction()
    {
        $entity = new Caisse();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }
    /**
     * Displays a form to create a new Caisse entity.
     *
     * @Route("/new", name="com_caisse_new_caisse_agence")
     * @Method("GET")
     * @Template()
     * @Secure(roles="ROLE_ADD_MOUVEMENT_CAISSE_AGENCE")
     */
    public function newCaisseAgenceAction()
    {
    	 
    	$em = $this->getDoctrine()->getManager();
    	$connection = $em->getConnection();
    	$statement = $connection->prepare("SELECT ag.id FROM agence ag,affecter af
        		                           where af.personnel=:personnel AND
        		                                 af.agence=ag.id");
    	$statement->bindValue('personnel', $this->getUser()->getPersonnel()->getId());
    	$statement->execute();
    	$ags=$statement->fetchAll();
    	$idAgence=$ags[0]['id'];
    	
    	$entity = $em->getRepository('ComDaufinBundle:Caisse')->findByAgence($idAgence);
    	$expeditions=$em->getRepository('ComDaufinBundle:Expedition')->findAll();
    	
    	if (!$entity) {
    		throw $this->createNotFoundException('Unable to find Caisse entity.');
    	}
    	return $this->render('ComDaufinBundle:MouvementCaisse:newMouvementCaisse.html.twig', array(
            'caisses'      => $entity,
    		'expeditions'=>$expeditions,
        ));
    }

    /**
     * Finds and displays a Caisse entity.
     *
     * @Route("/{id}", name="com_caisse_show")
     * @Method("GET")
     * @Template()
     * @Secure(roles="ROLE_SHOW_CAISSE")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:Caisse')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Caisse entity.');
        }

        $mouvements=$em->getRepository('ComDaufinBundle:MouvementCaisse')->findByCaisse($id);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'mouvements'      => $mouvements,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Finds and displays a Caisse entity.
     *
     * @Route("/{id}", name="com_caisse_show_caisse_agence")
     * @Method("GET")
     * @Template()
     * @Secure(roles="ROLE_SHOW_CAISSE_AGENCE")
     */
    public function showCaisseAgenceAction()
    {
    	 $params = $this->getRequest()->query->all();
    	
    	 $categorie = $params['categorie'];
    	
    	$em = $this->getDoctrine()->getManager();
    	$connection = $em->getConnection();   	
    	$statement = $connection->prepare("SELECT ag.id FROM agence ag,affecter af
        		                           where af.personnel=:personnel AND
        		                                 af.agence=ag.id");
    	$statement->bindValue('personnel', $this->getUser()->getPersonnel()->getId());
    	$statement->execute();
    	$ags=$statement->fetchAll();
    	$idAgence=$ags[0]['id'];
    
    	$entity = $em->getRepository('ComDaufinBundle:Caisse')->findOneBy(array('agence'=>$idAgence,'categorieCaisse'=>$categorie));
    
    	if (!$entity) {
    		throw $this->createNotFoundException('Unable to find Caisse entity.');
    	}
    
    	$mouvements=$em->getRepository('ComDaufinBundle:MouvementCaisse')->findByCaisse($entity->getId());
     
    	return array(
    			'entity'      => $entity,
    			'mouvements'      => $mouvements,
    			 
    	);
    }
    
    /**
     * Displays a form to edit an existing Caisse entity.
     *
     * @Route("/{id}/edit", name="com_caisse_edit")
     * @Method("GET")
     * @Template()
     * @Secure(roles="ROLE_EDIT_CAISSE")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:Caisse')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Caisse entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Caisse entity.
    *
    * @param Caisse $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Caisse $entity)
    {
        $form = $this->createForm(new CaisseType(), $entity, array(
            'action' => $this->generateUrl('com_caisse_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Caisse entity.
     *
     * @Route("/{id}", name="com_caisse_update")
     * @Method("PUT")
     * @Template("ComDaufinBundle:Caisse:edit.html.twig")
     * @Secure(roles="ROLE_EDIT_CAISSE")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:Caisse')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Caisse entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('com_caisse_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Caisse entity.
     *
     * @Route("/{id}", name="com_caisse_delete")
     * @Method("DELETE")
     * @Secure(roles="ROLE_DELETE_CAISSE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ComDaufinBundle:Caisse')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Caisse entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('com_caisse'));
    }

    /**
     * Creates a form to delete a Caisse entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('com_caisse_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
    
    //for Caisssss
    
    

    public function declarCaisseAction(){
    
    
    	$em = $this->getDoctrine()->getManager();
    	$connection = $em->getConnection();
    
    	$statement = $connection->prepare("SELECT ag.* FROM agence ag,affecter af
        		                           where af.personnel=:personnel AND
        		                                 af.agence=ag.id");
    	$statement->bindValue('personnel', $this->getUser()->getPersonnel()->getId());
    	$statement->execute();
    	$ags=$statement->fetchAll();
    	$idAgence=$ags[0]['ID'];
    
    	$statement = $connection->prepare("select s.* from secteur s,agence a, ville v
				                            where a.ville=v.id AND
				                           v.id=s.ville AND a.id=:agence ");
    	$statement->bindValue('agence',$idAgence);
    	$statement->execute();
    	$results=$statement->fetchAll();
    
    	$statement = $connection->prepare("SELECT count(*) as nbreExp from expedition e
				                              where e.recAgence=:agence AND e.Etat_Exp='Arrivage'  ");
    	$statement->bindValue('agence',$idAgence);
    	$statement->execute();
    	$tab=$statement->fetchAll();
    	$nbreExp=0;
    	$now=new \DateTime();
    
    	if(sizeof($tab)>=1) $nbreExp=$tab[0]['nbreExp'];
    
    	return $this->render('ComDaufinBundle:Caisse:declarCaisse.html.twig', array(
    			'agence' => $ags[0],
    			'secteurs' => $results,
    			'nbreExp' =>$nbreExp ,
    			'date' =>$now->format("Y-m-d") ,
    	));
    
    
    }
    
    public function getExpeditionCaisseAction(){
    
    	$em = $this->getDoctrine()->getManager();
    	$connection = $em->getConnection();
    	$params = $this->getRequest()->request->all();
    	$codeDeclaration=$params['codeDeclaration'];
    
    	$exped=$em->getRepository("ComDaufinBundle:Expedition")->findOneByCodeDeclaration($codeDeclaration);
    
    	if($exped==null){
    		$response = array("codeError" =>  27,
    				"message" =>"Expedition Introuvable",);
    		return new Response(json_encode($response));
    	}else {
    		$cheque=null;
    		$crbt=null;
    		$traite=null;
    		$BL=null;
    		//get Cheque
    		$statement = $connection->prepare("select  ID as id,NUM_CHEQUE as numCheque,TITRE_CHEQUE as titre,MONTANT_CHQ as montant,
					                                   DATE_ECHEANCE as date,NATURE_CHEQUE as nature ,ETAT_CHEQUE as etat  from  cheque c
				                            where c.exept=:expedition ");
    		$statement->bindValue('expedition',$exped->getId());
    		$statement->execute();
    		$results=$statement->fetchAll();
    		if(sizeof($results)>=1){
    			$cheque=$results[0];
    		}
    		//Traite
    		$statement = $connection->prepare("select  ID as id,TITRE_TRAITE as titre,MONTANT_TRT as montant,DATE_TRAITE as date
					                          from traite t
				                            where t.exept=:expedition ");
    		$statement->bindValue('expedition',$exped->getId());
    		$statement->execute();
    		$results=$statement->fetchAll();
    		if(sizeof($results)>=1){
    			$traite=$results[0];
    		}
    		//Crbt
    		$statement = $connection->prepare("select ID as id,TITRE_CRBT as titre,DATE_CRBT as date,MONTANT_CRBT as montant from crbt c
				                            where c.exept=:expedition ");
    		$statement->bindValue('expedition',$exped->getId());
    		$statement->execute();
    		$results=$statement->fetchAll();
    		if(sizeof($results)>=1){
    			$crbt=$results[0];
    		}
    			
    		//Bl
    		$statement = $connection->prepare("select  ID as id,NUM_BL as numBL,TITRE_BL_M as titre,DATE_BL_M as date from b_livraison_m b
				                            where b.exept=:expedition ");
    		$statement->bindValue('expedition',$exped->getId());
    		$statement->execute();
    		$results=$statement->fetchAll();
    		if(sizeof($results)>=1){
    			$BL=$results[0];
    		}
    			
    		//le Cas Port du
    		$prixHT=0;
    		$prixTTC=0;
    		$prixTVA=0;
    			
    
    
    		$statement = $connection->prepare("SELECT s.prix_HT as prixHT,s.TVA as prixTVA,s.prix_ttc as prixTTC,r.LIBELLE_RUB as libelRub
						                           FROM suiv_service s,rubrique r
						                           where exept=:expedition and rub=r.id  ");
    		$statement->bindValue('expedition',$exped->getId());
    		$statement->execute();
    		$results=$statement->fetchAll();
    		if(sizeof($results)>=1){
    				
    				
    			for ($i = 0; $i < sizeof($results); $i++){
    				$prixHT+=$results[$i]['prixHT'];
    				$prixTTC+=$results[$i]['prixTTC'];
    				$prixTVA+=$results[$i]['prixTVA'];
    					
    			}
    				
    		}
    			
    			
    		$mode;
    		if($exped->getMdPort()=='portDu') $mode='Port Du';
    		else $mode='Port Paye';
    			
    		$response = array("succes" =>  27,
    				"cheque" =>$cheque,
    				"crbt" =>$crbt,
    				"traite" =>$traite,
    				"bl" =>$BL,
    				"montantTTC" =>$prixTTC,
    				"montantTVA" =>$prixTVA,
    				"montantHT" =>$prixHT,
    				"modePort"=>$mode,
    				"etatRegExpedition"=>$exped->getEtatRegl()
    					
    		);
    		return new Response(json_encode($response));
    
    			
    	}
    }

    /**
     *
     *  @Secure(roles="ROLE_VALIDER_CHEQUE")
     */
    
    public function valideChequeAction(){
    	 
    	$em = $this->getDoctrine()->getManager();
    	$connection = $em->getConnection();
    	$params = $this->getRequest()->request->all();
    	$codeDeclaration=$params['codeDeclaration'];
    	$idCheque=$params['idCheque'];
    	$numCheque=$params['numCheque'];
    	$montantCheque=$params['montantCheque'];
    	$titreCheque=$params['titreCheque'];
    	$dateEcheanceCheque=$params['dateEcheanceCheque'];
    	$natureCheque=$params['natureCheque'];
    	$etatCheque=$params['etatCheque'];
    	$idAgence;
    
    	$cheque=$em->getRepository("ComDaufinBundle:Cheque")->find($idCheque);
    	
    	$statement = $connection->prepare("SELECT ag.id as id FROM agence ag,affecter af
        		                           where af.personnel=:personnel AND
        		                                 af.agence=ag.id");
    	$statement->bindValue('personnel', $this->getUser()->getPersonnel()->getId());
    	$statement->execute();
    	$args=$statement->fetchAll();
    	if(sizeof($args)>=1){
    		$idAgence=$args[0]['id'];
    	}
    
    	if($cheque!=null){
    		//$cheque=new Cheque();
    		if($cheque->getEtatValid()=='validee'){
    			$response = array("codeError" =>  27,
    					"message" =>"Validation Impossible, Le Chéque est déja Validée",);
    			return new Response(json_encode($response));
    				
    		}else{
    			$cheque->setEtatCheque($etatCheque);
    			//$cheque->setDateEcheance($dateEcheanceCheque);
    			$cheque->setTitreCheque($titreCheque);
    			$cheque->setNumCheque($numCheque);
    			$cheque->setNatureCheque($natureCheque);
    			$cheque->setEtatValid("validee");
    			$cheque->setDateValid(new \DateTime());
    			// Caisse et Mouvement
    			//get Caisse
    			$caisse=$em->getRepository("ComDaufinBundle:Caisse")->findOneBy(array('agence'=>$idAgence,'categorieCaisse'=>"Service"));
    			 
    			//$caisse=new Caisse();
    			// Virement vers la caisse
    			$caisse->setSoldeCaisse($caisse->getSoldeCaisse()+$cheque->getMontantChq());
    			//Creer Mouvement 
    			$mouvementCaisse=new MouvementCaisse();
    			$mouvementCaisse->setCaisse($caisse);
    			$mouvementCaisse->setDateMouvement(new \DateTime());
    			$mouvementCaisse->setAgence($caisse->getAgence());
    			$mouvementCaisse->setPersonnel($this->getUser()->getPersonnel());
    			$mouvementCaisse->setExpedition($cheque->getExept());
    			$mouvementCaisse->setValeur($cheque->getMontantChq());
    			$mouvementCaisse->setTypeMouvement("Versement");
    			$mouvementCaisse->setLibelleMouvement("Versement Chéque d'expédition");
    			
    			$em->persist($mouvementCaisse);
    			$em->flush();
    			$response = array("succes" =>  27,
    					"message" =>"Enregistrement du chéque réussie",);
    			return new Response(json_encode($response));
    		}
    	}
    	else {
    		$response = array("codeError" =>  27,
    				"message" =>"Cheque Introuvable",);
    		return new Response(json_encode($response));
    	}
    
    }
    /**
     *
     *  @Secure(roles="ROLE_VALIDER_TRAITE")
     */
    public function valideTraiteAction(){
    
    	$em = $this->getDoctrine()->getManager();
    	$connection = $em->getConnection();
    	$params = $this->getRequest()->request->all();
    	$codeDeclaration=$params['codeDeclaration'];
    	$idTraite=$params['idTraite'];
    	$titreTraite=$params['titreTraite'];
    	$dateTraite=$params['dateTraite'];
    	$traite=$em->getRepository("ComDaufinBundle:Traite")->find($idTraite);
    	
    	$idAgence;
    	
    	 
    	 
    	$statement = $connection->prepare("SELECT ag.id as id FROM agence ag,affecter af
        		                           where af.personnel=:personnel AND
        		                                 af.agence=ag.id");
    	$statement->bindValue('personnel', $this->getUser()->getPersonnel()->getId());
    	$statement->execute();
    	$args=$statement->fetchAll();
    	if(sizeof($args)>=1){
    		$idAgence=$args[0]['id'];
    	}
    	
    
    	if($traite!=null){
    		//$traite->setDateTraite($dateTraite);
    		if($traite->getEtatValid()=='validee'){
    			$response = array("codeError" =>  27,
    					"message" =>"Validation Impossible, La Traite est déja Validée",);
    			return new Response(json_encode($response));
    				
    		}else{
    			$traite->setTitreTraite($titreTraite);
    			$traite->setEtatValid("validee");
    			$traite->setDateValid(new \DateTime());
    			// Caisse et Mouvement
    			//get Caisse
    			//$traite=new Traite();
    			$caisse=$em->getRepository("ComDaufinBundle:Caisse")->findOneBy(array('agence'=>$idAgence,'categorieCaisse'=>"Service"));
    			
    			//$caisse=new Caisse();
    			// Virement vers la caisse
    			$caisse->setSoldeCaisse($caisse->getSoldeCaisse()+$traite->getMontantTrt());
    			//Creer Mouvement
    			$mouvementCaisse=new MouvementCaisse();
    			$mouvementCaisse->setDateMouvement(new \DateTime());
    			$mouvementCaisse->setCaisse($caisse);
    			$mouvementCaisse->setAgence($caisse->getAgence());
    			$mouvementCaisse->setPersonnel($this->getUser()->getPersonnel());
    			$mouvementCaisse->setExpedition($traite->getExept());
    			$mouvementCaisse->setValeur($traite->getMontantTrt());
    			$mouvementCaisse->setTypeMouvement("Versement");
    			$mouvementCaisse->setLibelleMouvement("Versement Traite d'expédition");
    			 
    			$em->persist($mouvementCaisse);
    			$em->flush();
    			$response = array("succes" =>  27,
    					"message" =>"Enregistrement du Traite réussie",);
    			return new Response(json_encode($response));
    		}
    	}
    	else {
    		$response = array("codeError" =>  27,
    				"message" =>"Traite Introuvable",);
    		return new Response(json_encode($response));
    	}
    
    }
    /**
     *
     *  @Secure(roles="ROLE_VALIDER_CRBT")
     */
    public function valideCrbtAction(){
    
    	$em = $this->getDoctrine()->getManager();
    	$connection = $em->getConnection();
    	$params = $this->getRequest()->request->all();
    	$codeDeclaration=$params['codeDeclaration'];
    	$idCrbt=$params['idCrbt'];
    	$montantCrbt=$params['montantCrbt'];
    	$titreCrbt=$params['titreCrbt'];
    	$dateCrbt=$params['dateCrbt'];

    	$idAgence;
    	$statement = $connection->prepare("SELECT ag.id as id FROM agence ag,affecter af
        		                           where af.personnel=:personnel AND
        		                                 af.agence=ag.id");
    	$statement->bindValue('personnel', $this->getUser()->getPersonnel()->getId());
    	$statement->execute();
    	$args=$statement->fetchAll();
    	if(sizeof($args)>=1){
    		$idAgence=$args[0]['id'];
    	}
    	 
    
    	$cRBT=$em->getRepository("ComDaufinBundle:Crbt")->find($idCrbt);
    
    	if($cRBT!=null){
    			
    		//$cRBT->setDateCrbt($dateCrbt);
    		if($cRBT->getEtatValid()=='validee'){
    			$response = array("codeError" =>  27,
    					"message" =>"Validation Impossible, Le Contre Remboursement est déja Validée",);
    			return new Response(json_encode($response));
    				
    		}else{
    			$cRBT->setEtatValid("validee");
    			$cRBT->setDateValid(new \DateTime());
    			$cRBT->setTitreCrbt($titreCrbt);
    			
    			// Caisse et Mouvement
    			//get Caisse
    			//$cRBT=new Crbt();
    			$caisse=$em->getRepository("ComDaufinBundle:Caisse")->findOneBy(array('agence'=>$idAgence,'categorieCaisse'=>"Service"));
    			 
    			//$caisse=new Caisse();
    			// Virement vers la caisse
    			$caisse->setSoldeCaisse($caisse->getSoldeCaisse()+$cRBT->getMontantCrbt());
    			//Creer Mouvement
    			$mouvementCaisse=new MouvementCaisse();
    			$mouvementCaisse->setDateMouvement(new \DateTime());
    			$mouvementCaisse->setAgence($caisse->getAgence());
    			$mouvementCaisse->setCaisse($caisse);
    			$mouvementCaisse->setPersonnel($this->getUser()->getPersonnel());
    			$mouvementCaisse->setExpedition($cRBT->getExept());
    			$mouvementCaisse->setValeur($cRBT->getMontantCrbt());
    			$mouvementCaisse->setTypeMouvement("Versement");
    			$mouvementCaisse->setLibelleMouvement("Versement Remboursement d'expédition ");
    			
    			$em->persist($mouvementCaisse);
    				
    			$em->flush();
    			$response = array("succes" =>  27,
    					"message" =>"Enregistrement du CRBT réussie",);
    			return new Response(json_encode($response));
    		}
    	}
    	else {
    		$response = array("codeError" =>  27,
    				"message" =>"CRBT Introuvable",);
    		return new Response(json_encode($response));
    	}
    
    }
    /**
     *
     *  @Secure(roles="ROLE_VALIDER_RETOUR_BL")
     */
    public function valideBLAction(){
    
    	$em = $this->getDoctrine()->getManager();
    	//$connection = $em->getConnection();
    	$params = $this->getRequest()->request->all();
    	$codeDeclaration=$params['codeDeclaration'];
    	$idBL=$params['idBL'];
    	$numBL=$params['numBL'];
    	$titreBL=$params['titreBL'];
    	$dateBL=$params['dateBL'];

//     	$idAgence;
//     	$statement = $connection->prepare("SELECT ag.* FROM agence ag,affecter af
//         		                           where af.personnel=:personnel AND
//         		                                 af.agence=ag.id");
//     	$statement->bindValue('personnel', $this->getUser()->getPersonnel()->getId());
//     	$statement->execute();
//     	$ags=$statement->fetchAll();
//     	if(sizeof($args)>=1){
//     		$idAgence=$args[0]['id'];
//     	}
    	
    
    	$BL=$em->getRepository("ComDaufinBundle:BLivraisonM")->find($idBL);
    
    	if($BL!=null){
    		//	$BL=new BLivraisonM();
    		if($BL->getEtatValid()=='validee'){
    			$response = array("codeError" =>  27,
    					"message" =>"Validation Impossible, Le Bon Livraison est déja Validée",);
    			return new Response(json_encode($response));
    				
    		}else{
    			$BL->setEtatValid("validee");
    			$BL->setDateValid(new \DateTime());
    			//$BL->setDateBlM($dateBL);
    			$BL->setTitreBlM($titreBL);
    			$em->flush();
    			$response = array("succes" =>  27,
    					"message" =>"Enregistrement du BL réussie",);
    			return new Response(json_encode($response));
    		}
    	}
    	else {
    		$response = array("codeError" =>  27,
    				"message" =>"BL Introuvable",);
    		return new Response(json_encode($response));
    	}
    
    
    }
    /**
     *
     *  @Secure(roles="ROLE_VALIDER_PORT_PAYE")
     */
    public function validePortAction(){
    
    	$em = $this->getDoctrine()->getManager();
    	$params = $this->getRequest()->request->all();
    	$connection = $em->getConnection();
    	
    	$codeDeclaration=$params['codeDeclaration'];
    	$valeurTTC=$params['valeurTTC'];
    	$refPaiement=$params['refPaiement'];
    	$modePaiement=$params['modePaiement'];
    	
        $expedition=$em->getRepository("ComDaufinBundle:Expedition")->findOneByCodeDeclaration($codeDeclaration);
    
        $idAgence;
        $statement = $connection->prepare("SELECT ag.id as id FROM agence ag,affecter af
        		                           where af.personnel=:personnel AND
        		                                 af.agence=ag.id");
        $statement->bindValue('personnel', $this->getUser()->getPersonnel()->getId());
        $statement->execute();
        $args=$statement->fetchAll();
        if(sizeof($args)>=1){
        	$idAgence=$args[0]['id'];
        }
        
    		
    
    	if($expedition!=null){
    		//$expedition=new Expedition();
    			
    		if($expedition->getEtatRegl()=='Reglee'){
    			$response = array("codeError" =>  27,
    					"message" =>"Validation Impossible, Le Mode Port est déja Validée",);
    			return new Response(json_encode($response));
    				
    		}else{
    			//get All Service for reglee
    			$services=$em->getRepository("ComDaufinBundle:SuivService")->findByExept($expedition->getId());
    			foreach ($services as $service){
    				//$service=new SuivService();
    				$service->setDateReglement(new \DateTime());
    				$service->setRefPaiement($refPaiement);
    				$service->setModeReglement($modePaiement);
    				$service->setEtatReglement("Reglee");
    				$service->setValeurReglement($valeurTTC);
    			}
    
    			$expedition->setDateReglement(new \DateTime());
    			$expedition->setRefPaiement($refPaiement);
    			$expedition->setModeRegl($modePaiement);
    			$expedition->setEtatRegl("Reglee");
    			
    			$caisse=$em->getRepository("ComDaufinBundle:Caisse")->findOneBy(array('agence'=>$idAgence,'categorieCaisse'=>"Service"));
    			
    			///$caisse=new Caisse();
    			// Virement vers la caisse
    			$caisse->setSoldeCaisse($caisse->getSoldeCaisse()+$expedition->getTotalMontant());
    			//Creer Mouvement
    			$mouvementCaisse=new MouvementCaisse();
    			$mouvementCaisse->setDateMouvement(new \DateTime());
    			$mouvementCaisse->setAgence($caisse->getAgence());
    			$mouvementCaisse->setCaisse($caisse);
    			$mouvementCaisse->setPersonnel($this->getUser()->getPersonnel());
    			$mouvementCaisse->setExpedition($expedition);
    			$mouvementCaisse->setValeur($expedition->getTotalMontant());
    			$mouvementCaisse->setTypeMouvement("Versement");
    			$mouvementCaisse->setLibelleMouvement("Versement Port d'expédition ");
    			 
    			$em->persist($mouvementCaisse);
    			
    			$em->flush();
    			$response = array("succes" =>  27,
    					"message" =>"Encaissement d'expedition réussie",);
    			return new Response(json_encode($response));
    		}
    	}else {
    		$response = array("codeError" =>  27,
    				"message" =>"Expedition  Introuvable",);
    		return new Response(json_encode($response));
    	}
    
    
    }
    /**
     *
     *  @Secure(roles="ROLE_VALIDER_PORT_PAYE")
     */
    
    public function formValidPortPayeAction(){
    
    	return $this->render('ComDaufinBundle:Caisse:validePortPaye.html.twig', array(
    
    	));
    
    }
    
 
    
}
