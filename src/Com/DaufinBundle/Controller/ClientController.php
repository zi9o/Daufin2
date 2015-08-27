<?php

namespace Com\DaufinBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Com\DaufinBundle\Entity\Client;
use Com\DaufinBundle\Entity\Contrat;
use Com\DaufinBundle\Entity\Site;
use Com\DaufinBundle\Entity\ContTablePrix;
use Com\DaufinBundle\Form\ClientType;
use JMS\SecurityExtraBundle\Annotation\Secure;
/**
 * Client controller.
 *
 */
class ClientController extends Controller
{

    /**
     * Lists all Client entities.
     * @Secure(roles="ROLE_SHOW_ALL_CLIENT")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ComDaufinBundle:Client')->findAll();

        return $this->render('ComDaufinBundle:Client:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Client entity.
     * @Secure(roles="ROLE_ADD_CLIENT")
     */
    public function createAction(Request $request)
    {
        $focusTab=$request->get('TabLib');
        if ($focusTab=='Client')
        {
            $entity = new Client();
            $form = $this->createCreateForm($entity);
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($entity);
                $em->flush();

                return $this->redirect($this->generateUrl('com_Client_show', array('id' => $entity->getId())));
        }
        }
        
        if ($focusTab=='Contrat')
        {
            $entity = new Contrat();
            $entity->setDateOuvert(new \DateTime($request->get('dateOuvertCont')));
            $entity->setDateFerm(new \DateTime($request->get('dateFermCont')));
            $entity->setEtatContart($request->get('EtContrat'));
            $entity->setmPaiment($request->get('MPaiment'));
            $em = $this->getDoctrine()->getManager();
            $clt = $em->getRepository('ComDaufinBundle:Client')->find($request->get('idClient'));
            $entity->setClient($clt);
            
                $em->persist($entity);
                $em->flush();

                return $this->redirect($this->generateUrl('com_Client_show', array('id' => $entity->getId())));
        }
        
        if ($focusTab=='Site')
        {
            $entity = new Site();
            $entity->setAdresSite($request->get('AdresSite'));
            $entity->setLibelleSite($request->get('LibSite'));
            $em = $this->getDoctrine()->getManager();
            $clt = $em->getRepository('ComDaufinBundle:Client')->find($request->get('idClient'));
            $entity->setClient($clt);
            $sect = $em->getRepository('ComDaufinBundle:Secteur')->find($request->get('secteur'));
            $entity->setSecteur($sect);
            
                $em->persist($entity);
                $em->flush(); 
                return new Response(json_encode($entity));
        }
        
        if ($focusTab=='T_Prix')
        {
            $entity = new ContTablePrix();
            $entity->setDateFermeture(new \DateTime($request->get('date_Ferm')));
            $entity->setDateOuverture(new \DateTime($request->get('date_Ouvert')));
            $entity->setEtat($request->get('etat'));
            $entity->setIdTVal($request->get('tval'));
            $entity->setTva($request->get('tva-prix'));
            $entity->setValeur($request->get('valeur'));
            $entity->setValeurMax($request->get('vmax'));
            $entity->setValeurMin($request->get('vmin'));
            $em = $this->getDoctrine()->getManager();
            $strj = $em->getRepository('ComDaufinBundle:SousTrajet')->find($request->get('strajet'));
            $entity->setIdSTrajet($strj);
            $rubr = $em->getRepository('ComDaufinBundle:Rubrique')->find($request->get('rubrique'));
            $entity->setIdRub($rubr);
            $ctrt = $em->getRepository('ComDaufinBundle:Contrat')->find($request->get('ctrat'));
            $entity->setIdContrat($ctrt);
            
                $em->persist($entity);
                $em->flush();
            $entity=$em->getRepository('ComDaufinBundle:Contrat')->findAll();
            /*$response = array("dateferm" =>  $entity->getDateFermeture(),
                              "dateouvert" =>,					
			);*/
                return new Response(json_encode($entity));
            
        }

        return $this->render('ComDaufinBundle:Client:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Client entity.
     *
     * @param Client $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Client $entity)
    {
        $form = $this->createForm(new ClientType(), $entity, array(
            'action' => $this->generateUrl('com_Client_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Créer','attr'=>array('class'=>'btn btn-success','style'=>'width:100px;')));

        return $form;
    }

    /**
     * Displays a form to create a new Client entity.
     * @Secure(roles="ROLE_ADD_CLIENT")
     */
    public function newAction()
    {
        $em = $this->getDoctrine()->getManager();

        $villes = $em->getRepository('ComDaufinBundle:Ville')->findAll();
        $rubriques = $em->getRepository('ComDaufinBundle:Rubrique')->findAll();
        $strajets = $em->getRepository('ComDaufinBundle:SousTrajet')->findAll();
        $valtypes = $em->getRepository('ComDaufinBundle:TypeValeur')->findAll();
        $entity = new Client();
        $form   = $this->createCreateForm($entity);

        return $this->render('ComDaufinBundle:Client:new.html.twig', array(
            'entity' => $entity,
            'villes'=> $villes,
            'rubriques' => $rubriques,
            'strajets' => $strajets,
            'valtypes' => $valtypes,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Client entity.
     * @Secure(roles="ROLE_SHOW_CLIENT")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:Client')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Client entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ComDaufinBundle:Client:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Client entity.
     * @Secure(roles="ROLE_EDIT_CLIENT")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:Client')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Client entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ComDaufinBundle:Client:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    

    /**
     * Displays a form to edit an existing Client entity.
     * @Secure(roles="ROLE_EDIT_CLIENT")
     */
        public function compteeditAction(){
        $em = $this->getDoctrine()->getManager();

        $villes = $em->getRepository('ComDaufinBundle:Ville')->findAll();
        $rubriques = $em->getRepository('ComDaufinBundle:Rubrique')->findAll();
        $strajets = $em->getRepository('ComDaufinBundle:SousTrajet')->findAll();
        $valtypes = $em->getRepository('ComDaufinBundle:TypeValeur')->findAll();
        $entities = $em->getRepository('ComDaufinBundle:Client')->findBy(array('typeClient'=>'Compte'));
        $contrats = $em->getRepository('ComDaufinBundle:Contrat')->findBy(array('etatContart'=>'EnCours'));
        return $this->render('ComDaufinBundle:Client:compteedit.html.twig', array(
            'entities' => $entities,
            'villes'=> $villes,
            'rubriques' => $rubriques,
            'strajets' => $strajets,
            'valtypes' => $valtypes,
            'contrats' => $contrats,
        ));
    }

    /**
    * Creates a form to edit a Client entity.
    *
    * @param Client $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Client $entity)
    {
        $form = $this->createForm(new ClientType(), $entity, array(
            'action' => $this->generateUrl('com_Client_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Modifier','attr'=>array('class'=>'btn btn-warning','style'=>'width:100px;')));

        return $form;
    }
    /**
     * Edits an existing Client entity.
     *  @Secure(roles="ROLE_EDIT_CLIENT")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:Client')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Client entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('com_Client_edit', array('id' => $id)));
        }

        return $this->render('ComDaufinBundle:Client:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Client entity.
     *  @Secure(roles="ROLE_DELETE_CLIENT")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ComDaufinBundle:Client')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Client entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('com_Client'));
    }

    /**
     * Creates a form to delete a Client entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     * Deletes a Client entity.
     *  @Secure(roles="ROLE_DELETE_CLIENT")
     */
 
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('com_Client_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Supprimer','attr'=>array('class'=>'btn btn-danger','style'=>'width:100px;')))
            ->getForm()
        ;
    }
    /**
     * Deletes a Client entity.
     *  @Secure(roles="ROLE_ADD_CLIENT")
     */
    
    public function createClientAction()
    {
        $em = $this->getDoctrine()->getManager();
        //$connection = $em->getConnection();
        $params = $this->getRequest()->request->all();
        $Client=new Client();
        $Client->setTypeClient($params['typeClt']);
        $Client->setCodeClient($params['codeClt']);
        $Client->setRSociale($params['raisSoc']);
        $Client->setPatente($params['patente']);
        $Client->setRCommerce($params['regCom']);
        $Client->setIdFiscale($params['dirGenerl']);
        $Client->setDirGeneral($params['idFiscal']);
        $Client->setDirFinancier($params['dirFinanc']);
        $Client->setTelClt($params['telClt']);
        $Client->setFaxClt($params['faxClt']);
        $Client->setContact($params['contact']);
        $Client->setAdresseClt($params['adresse']);

        $em->persist($Client);
        $em->flush();
        $clt=$em->getRepository('ComDaufinBundle:Client')->find($Client->getId());

        $response = array("idClient" => $clt->getId(),"raisSoc" => $clt->getRSociale(),);
			
        return new Response(json_encode($response));
                
    }
    /**
     * Deletes a Client entity.
     *  @Secure(roles="ROLE_DELETE_CLIENT")
     */
    
    public function createContratAction()
    {
        $em = $this->getDoctrine()->getManager();
        //$connection = $em->getConnection();
        $params = $this->getRequest()->request->all();
        $Contrat=new Contrat();
        $Contrat->setDateFermeture(new \DateTime($params['dateFerm']));
        $Contrat->setDateOuvert(new \DateTime($params['dateOuvert']));
        $Contrat->setMPaiment($params['modePaie']);
        $Contrat->setEtatContart($params['etatCont']);
        $clt=$em->getRepository('ComDaufinBundle:Client')->find($params['idClient']);
        $Contrat->setClient($clt);
        $em->persist($Contrat);
        $em->flush();
        
        $response = array("idContrat" => $Contrat->getId(),"message" =>"Bien Enregistrer",);
	//$response = array("idContrat" => "lmlezfldsmf,dslfdsldsf,ml","message" =>"Bien Enregistrer",);		
        return new Response(json_encode($response));
    }
    /**
     * Deletes a Client entity.
     *  @Secure(roles="ROLE_DELETE_CLIENT")
     */
    
    public function createSiteAction()
    {
        $em = $this->getDoctrine()->getManager();
        //$connection = $em->getConnection();
        $params = $this->getRequest()->request->all();
        $Site=new Site();
        $Site->setAdresSite($params['AdresseSite']);
        $Site->setLibelleSite($params['LibelleSite']);
        $sect=$em->getRepository('ComDaufinBundle:Secteur')->find($params['idSecteur']);
        $clt=$em->getRepository('ComDaufinBundle:Client')->find($params['idClient']);
        $Site->setSecteur($sect);
        $Site->setClient($clt);
        
        $em->persist($Site);
        $em->flush();
        
        $Sit=$em->getRepository('ComDaufinBundle:Site')->find($Site->getId());
        $response = array("LibelleSite" => $Sit->getLibelleSite(),
            "AdresseSite" => $Sit->getAdresSite(),
            "LibelleSecteur" => $sect->getlibelleSecteur(),);
       // return new Response(json_encode($results));
        if(sizeof($response)>=1){
			return new Response(json_encode($response));
		
		}
		else {
			$response = array("code" =>  23,
 			"message" =>"Aucun éléments",					
			);
			return new Response(json_encode($response));
		}
       /* $response = array("idSite" => $clt->getId(),"message" =>"Bien Enregistrer",);
			
        return new Response(json_encode($response));*/
                
    }
    /**
     * Deletes a Client entity.
     *  @Secure(roles="ROLE_DELETE_CLIENT")
     */
    
    public function createContTabPrixAction()
    {
        $em = $this->getDoctrine()->getManager();
        //$connection = $em->getConnection();
        $params = $this->getRequest()->request->all();
        $CTabPrix=new ContTablePrix();
        
        $CTabPrix->setDateFermeture(new \DateTime($params['Date_Ferm']));
        $CTabPrix->setDateOuverture(new \DateTime($params['Date_Ouvert']));
        
        $CTabPrix->setEtat($params['Etat_Prix']);
        $CTabPrix->setTva($params['TVA_Prix']);
        $CTabPrix->setValeur($params['Vale']);
        $CTabPrix->setValeurMax($params['Val_Max']);
        $CTabPrix->setValeurMin($params['Val_Min']);
        
        $Contr=$em->getRepository('ComDaufinBundle:Contrat')->find($params['idContrat']);
        $Rub=$em->getRepository('ComDaufinBundle:Rubrique')->find($params['idRubrique']);
        $Straj=$em->getRepository('ComDaufinBundle:SousTrajet')->find($params['idStrajet']);
        $Tvale=$em->getRepository('ComDaufinBundle:TypeValeur')->find($params['idTvale']);
        
        $CTabPrix->setIdContart($Contr);
        $CTabPrix->setIdRub($Rub);
        $CTabPrix->setIdSTrajet($Straj);
        $CTabPrix->setIdTVal($Tvale);
        
        $em->persist($CTabPrix);
        $em->flush();
        $DepVille=$em->getRepository('ComDaufinBundle:Ville')->find($Straj->getVilleDepart());
        $ArvVille=$em->getRepository('ComDaufinBundle:Ville')->find($Straj->getVilleArrivee());
        
        $response = array("idContrat" => $Contr->getId(),
            "LibelleRub" => $Rub->getLibelleRub(),
            "LibelleTValeur" => $Tvale->getLibelleTVal(),
            "VilleAriv" => $ArvVille->getLibelleVille(),
            "VilleDep" => $DepVille->getLibelleVille(),
            "Valeur" =>  $CTabPrix->getValeur(),
            "TVA" =>  $CTabPrix->getTva(),
            "VMax" =>  $CTabPrix->getValeurMax(),
            "VMin" =>  $CTabPrix->getValeurMin(),
            "DateOuvert" => $CTabPrix->getDateOuverture()->format('Y-m-d'),
            "DateFerm" =>  $CTabPrix->getDateFermeture()->format('Y-m-d'),
            "Etat" =>  $CTabPrix->getEtat(),);
       // return new Response(json_encode($results));
        if(sizeof($response)>=1){
			return new Response(json_encode($response));
		
		}
		else {
			$response = array("code" =>  23,
 			"message" =>"Aucun éléments",					
			);
			return new Response(json_encode($response));
		}
      // $response = array("message" =>"khaddam",);
			
     //   return new Response(json_encode($response));
                
    }    
    /**
     * Deletes a Client entity.
     *  @Secure(roles="ROLE_DELETE_CLIENT")
     */
    
    public function SelectClientAction()
    {
        $em = $this->getDoctrine()->getManager();
        $params = $this->getRequest()->request->all();
        $Client=$em->getRepository('ComDaufinBundle:Client')->find($params['idClient']);
        $response = array(
            "typeClt" => $Client->getTypeClient(),
            "codeClt" => $Client->getCodeClient(),
            "raisSoc" => $Client->getRSociale(),
            "patente" => $Client->getPatente(),
            "regCom" => $Client->getRCommerce(),
            "dirGenerl" => $Client->getDirGeneral(),
            "dirFinanc" => $Client->getDirFinancier(),
            "idFiscal" => $Client->getIdFiscale(),
            "telClt" => $Client->getTelClt(),
            "faxClt" => $Client->getFaxClt(),
            "contact" => $Client->getContact(),
            "adresse" => $Client->getAdresseClt(),);
       // return new Response(json_encode($results));
        if(sizeof($Client)>=1){
			return new Response(json_encode($response));
		
		}
		else {
			$response = array("code" =>  23,
 			"message" =>"Aucun éléments",					
			);
			return new Response(json_encode($response));
		}
    }
    /**
     * Deletes a Client entity.
     *  @Secure(roles="ROLE_DELETE_CLIENT")
     */
    
public function chargeContratAction()
{        
        $params = $this->getRequest()->request->all();
        $clientId=$params['idClient'];

        $em = $this->container->get('doctrine')->getEntityManager();
	$qb = $em->createQueryBuilder();
	$qb->select('entities')
			->from('ComDaufinBundle:Contrat','entities')
			->where('(entities.client) = :cltId')
			->setParameter('cltId', $clientId);
	$query = $qb->getQuery();
	$entities = $query->getArrayResult();
 
        
                if($entities){
			return new Response(json_encode($entities));
		
		}
		else {
			$response = array("code" =>  23,
 			"message" =>"Aucune Contrat",					
			);
			return new Response(json_encode($response));
		}

}
/**
 * Deletes a Client entity.
 *  @Secure(roles="ROLE_DELETE_CLIENT")
 */

public function SelectContratAction()
{
    $em = $this->getDoctrine()->getManager();
        $params = $this->getRequest()->request->all();
        $Contrat=$em->getRepository('ComDaufinBundle:Contrat')->find($params['idContrat']);
        $response =array('id'=>$Contrat->getId(),
           'dateOuvert' => $Contrat->getDateOuvert()->format('Y-m-d'),
           'dateFerm' => $Contrat->getDateFermeture()->format('Y-m-d'),
           'modePaim' => $Contrat->getMPaiment(),
           'etatCont' => $Contrat->getEtatContart(),);
       // return new Response(json_encode($results));
        if(sizeof($Contrat)>=1){
			return new Response(json_encode($response));
		
		}
		else {
			$response = array("code" =>  23,
 			"message" =>"Aucun éléments",					
			);
			return new Response(json_encode($response));
		}
}

/**
 * Deletes a Client entity.
 *  @Secure(roles="ROLE_DELETE_CLIENT")
 */

public function chargeSiteAction()
{
    $params = $this->getRequest()->request->all();
        $clientId=$params['idClient'];

        $em = $this->getDoctrine()->getManager();
        
        $statement = $em->getConnection()->prepare("SELECT `LIBELLE_SITE`,`ADRES_SITE`,`Code_Secteur`,`LIBELLE_SECTEUR`
                                            FROM `site`,`secteur`  
                                            WHERE `site`.`secteur`=`secteur`.ID
                                            AND `Client`=:cltId" );
		$statement->bindValue('cltId',$clientId);
		$statement->execute();
		$entities = $statement->fetchAll();
        
                if($entities){
			return new Response(json_encode($entities));
		
		}
		else {
			$response = array("code" =>  23,
 			"message" =>"Aucun Site",					
			);
			return new Response(json_encode($response));
		}
}

/**
 * Deletes a Client entity.
 *  @Secure(roles="ROLE_DELETE_CLIENT")
 */

public function chargeContTabPrixAction()
{
     $params = $this->getRequest()->request->all();
        $contratId=$params['idContrat'];

        $em = $this->getDoctrine()->getManager();
        
        $statement = $em->getConnection()->prepare("SELECT `ID_CONTART`,`VALEUR`,`VALEUR_MAX`,`VALEUR_MIN`,`TVA`,`DATE_OUVERTURE`,`DATE_FERMETURE`,
                                                    `ETAT`,r.`LIBELLE_RUB`,tv.`LIBELLE_T_VAL`,v1.`LIBELLE_VILLE` as `VILLE_Depart`, 
                                                    v2.`LIBELLE_VILLE` as `VILLE_Arrivee` 
                                                    FROM cont_table_prix ctp, rubrique r, type_valeur tv, sous_trajet st 
                                                    INNER JOIN ville as v1 on st.`VILLE_Depart` = v1.ID 
                                                    INNER JOIN ville as v2 on st.`VILLE_Arrivee` = v2.ID 
                                                    WHERE ctp.`ID_RUB` = r.ID AND ctp.`ID_T_VAL` = tv.ID AND ctp.`ID_S_TRAJET` = st.ID 
                                                    AND`ID_CONTART`=:cntrtId");
		$statement->bindValue('cntrtId',$contratId);
		$statement->execute();
		$entities = $statement->fetchAll();
        
                if($entities){
			return new Response(json_encode($entities));
		
		}
		else {
			$response = array("code" =>  23,
 			"message" =>"Aucun Site",					
			);
			return new Response(json_encode($response));
		}   
}



}
