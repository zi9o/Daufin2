<?php

namespace Com\DaufinBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Com\DaufinBundle\Entity\Facture;
use Com\DaufinBundle\Form\FactureType;
use Com\DaufinBundle\Entity\Client;
use Com\DaufinBundle\Entity\Expedition;
use Com\DaufinBundle\Entity\SuivService;
use JMS\SecurityExtraBundle\Annotation\Secure;

use ExcelAnt\Adapter\PhpExcel\Workbook\Workbook,
    ExcelAnt\Adapter\PhpExcel\Sheet\Sheet,
    ExcelAnt\Adapter\PhpExcel\Writer\Writer,
    ExcelAnt\Table\Table,
    ExcelAnt\Coordinate\Coordinate;
use ExcelAnt\Adapter\PhpExcel\Writer\WriterFactory,
    ExcelAnt\Adapter\PhpExcel\Writer\PhpExcelWriter\Excel5;

/**
 * Facture controller.
 *
 */
class FactureController extends Controller {

    /**
     * Lists all Facture entities.
     * @Secure(roles="ROLE_ADD_FACTURE")
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $entitiesCompte = $em->getRepository('ComDaufinBundle:Client')->findBy(array('typeClient' => 'Compte'));
        $entitiesParticulier = $em->getRepository('ComDaufinBundle:Client')->findBy(array('typeClient' => 'Particulier'));

        return $this->render('ComDaufinBundle:Facture:index.html.twig', array(
                    'entitiesCompte' => $entitiesCompte,
                    'entitiesParticulier' => $entitiesParticulier,
        ));
    }

    /**
     * Creates a new Facture entity.
     *
     */
    public function createAction(Request $request) {
        $entity = new Facture();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('com_facture_show', array('id' => $entity->getId())));
        }

        return $this->render('ComDaufinBundle:Facture:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Facture entity.
     *
     * @param Facture $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Facture $entity) {
        $form = $this->createForm(new FactureType(), $entity, array(
            'action' => $this->generateUrl('com_facture_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Facture entity.
     *
     */
    public function newAction() {
        $entity = new Facture();
        $form = $this->createCreateForm($entity);

        return $this->render('ComDaufinBundle:Facture:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Facture entity.
     *
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:Facture')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Facture entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ComDaufinBundle:Facture:show.html.twig', array(
                    'entity' => $entity,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Facture entity.
     *
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:Facture')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Facture entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ComDaufinBundle:Facture:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Facture entity.
     *
     * @param Facture $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Facture $entity) {
        $form = $this->createForm(new FactureType(), $entity, array(
            'action' => $this->generateUrl('com_facture_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Facture entity.
     *
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:Facture')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Facture entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('com_facture_edit', array('id' => $id)));
        }

        return $this->render('ComDaufinBundle:Facture:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Facture entity.
     *
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ComDaufinBundle:Facture')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Facture entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('com_facture'));
    }

    /**
     * Creates a form to delete a Facture entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('com_facture_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Delete'))
                        ->getForm()
        ;
    }

    /**
     * Lists all Facture entities.
     * @Secure(roles="ROLE_ADD_FACTURE")
     */
    public function FindFactureAction() {
        $em = $this->getDoctrine()->getManager();

        $connection = $em->getConnection();

        $params = $this->getRequest()->request->all();

        $codeDec = $params['codeDec'];
        $dateCreationDu = $params['dateCreationDu'];
        $dateCreationAu = $params['dateCreationAu'];
        $CodeClientCompte = $params['CodeClientCompte'];
        $CodeClientParticulier = $params['CodeClientParticulier'];

        if ($codeDec != "") {
            $request = "SELECT
                e.id as id_exp,
                code_Declaration as code_dec,
                DATE_DECL as date_declaration,
                env_date as Date_envoi,
                rec_date as Date_rec,
                (select a.libelle_ag from agence a where a.id=e.envAgence) as AgenceD,
                (select a.libelle_ag from agence a where a.id=e.recAgence)  as AgenceR,
                ETAT_EXP as statut,
                POIDS_EXP as poid,
                NBR_COLIS as nbColis,
                md_port as mode,
                sum(s.prix_HT) as ht,
                sum(s.tva) as tva,
                sum(s.prix_ttc) as ttc
             FROM expedition e
             join suiv_service as s on (e.id=s.exept)
             join client as c on (c.id=e.env_client)
             where e.etat_regl='nonReglee' and facture is null and e.code_Declaration=:codeDec
              group by e.code_Declaration";

            $statement = $connection->prepare($request);
            $statement->bindValue('codeDec', $codeDec);
        } else {
            $request = "SELECT
		e.id as id_exp,
                code_Declaration as code_dec,
                DATE_DECL as date_declaration,
                env_date as Date_envoi,
                rec_date as Date_rec,
                (select a.libelle_ag from agence a where a.id=e.envAgence) as AgenceD,
                (select a.libelle_ag from agence a where a.id=e.recAgence)  as AgenceR,
                ETAT_EXP as statut,
                POIDS_EXP as poid,
                NBR_COLIS as nbColis,
                md_port as mode,
                sum(s.prix_HT) as ht,
                sum(s.tva) as tva,
                sum(s.prix_ttc) as ttc
             FROM expedition e
             join suiv_service as s on (e.id=s.exept)
             join client as c on ((c.id=e.env_client and e.md_port='portPaye' ) or (c.id=e.rec_client and e.md_port='portDu'))
             where etat_regl='nonReglee' and facture is null and c.id=:CodeClient
             and (e.DATE_DECL BETWEEN :dateCreationDu AND :dateCreationAu)
             group by e.code_Declaration";



            $statement = $connection->prepare($request);

            $statement->bindValue('dateCreationDu', $dateCreationDu);
            $statement->bindValue('dateCreationAu', $dateCreationAu);
            if ($CodeClientCompte != -1) {
                $statement->bindValue('CodeClient', $CodeClientCompte);
            } else {
                $statement->bindValue('CodeClient', $CodeClientParticulier);
            }
        }
        $statement->execute();
        $results = $statement->fetchAll();
        if (sizeof($results) >= 1) {
            $response = array();
            foreach ($results as $res) {
                $response[] = array_merge(
                        array(
                            "id_exp" => $res['id_exp'],
                            "code_dec" => $res['code_dec'],
                            "date_declaration" => $res['date_declaration'],
                            "Date_envoi" => $res['Date_envoi'],
                            "Date_rec" => $res['Date_rec'],
                            "statut" => $res['statut'],
                            "AgenceD" => $res['AgenceD'],
                            "AgenceR" => $res['AgenceR'],
                            "poid" => $res['poid'],
                            "nbColis" => $res['nbColis'],
                            "mode" => $res['mode'],
                            "ht" => $res['ht'],
                            "tva" => $res['tva'],
                            "ttc" => $res['ttc'],
                ));
            }

            return new Response(json_encode($response));
        } else {

            $response = array("codeError" => 40,
                "message" => "Aucune expedition trouvée",);
            return new Response(json_encode($response));
        }
    }

    /**
     * Lists all Facture entities.
     * @Secure(roles="ROLE_ADD_FACTURE")
     */
    public function genererFactureAction(){
        
        
        $em = $this->getDoctrine()->getManager();
        
        $connection = $em->getConnection();     
        $params = $this->getRequest()->request->all();      
        $idExpeditions = $params['idExpeditions'];
        
        $ids=array();
        foreach ($idExpeditions as $value) {
            array_push($ids, $value);
        }
        
        $inQuery = implode(',', array_fill(0, count($ids), '?'));
             
            $request = "SELECT
                e.id as id_exp,
                code_Declaration as code_dec,
                DATE_DECL as date_declaration,
                env_date as Date_envoi,
                rec_date as Date_rec,
                (select a.libelle_ag from agence a where a.id=e.envAgence) as AgenceD,
                (select a.libelle_ag from agence a where a.id=e.recAgence)  as AgenceR,
                ETAT_EXP as statut,
                POIDS_EXP as poid,
                NBR_COLIS as nbColis,
                md_port as mode,
                sum(s.prix_HT) as ht,
                sum(s.tva) as tva,
                sum(s.prix_ttc) as ttc
             FROM expedition e
             join suiv_service as s on (e.id=s.exept)
            
             where e.id IN(" . $inQuery . ")           
             group by e.code_Declaration";          
             
            $statement = $connection->prepare($request);
            
         foreach ($ids as $k => $id)
                {
                    $statement->bindValue(($k+1), $id);
                }
            $statement->execute();
            
            $results = $statement->fetchAll();
            
            if (sizeof($results) >= 1)  {
                $exped=$em->getRepository("ComDaufinBundle:Expedition")->find($idExpeditions[0]);
                //$exped=new Expedition();
                
                if($exped->getFacture()!=null){
                    $response = array("codeError" => 40,
                            "message" => "Expedition ".$exped->getCodeDeclaration()." est associée a la facture ".$exped->getFacture()->getNumFacture(),);
                    return new Response(json_encode($response));
                }
                $date=new \DateTime();
                $codeClient;
                $client;
                $telClient;
                
                if($exped->getMdPort()=='portDu'){
                    $codeClient=$exped->getRecClient()->getCodeClient();
                    $telClient=$exped->getRecClient()->getTelClt();

                    if($exped->getRecClient()->getTypeClient()=='Compte'){
                      $client=$exped->getRecClient()->getRSociale();
                        }
                    else{
                        $client=$exped->getRecClient()->getNomPart().' '.$exped->getRecClient()->getPrenomPart();
                    }   
                }
                else{
                    
                    $codeClient=$exped->getEnvClient()->getCodeClient();
                    $telClient=$exped->getEnvClient()->getTelClt();
                    
                    if($exped->getEnvClient()->getTypeClient()=='Compte'){
                        $client=$exped->getEnvClient()->getRSociale();
                    }
                    else{
                        $client=$exped->getEnvClient()->getNomPart().' '.$exped->getEnvClient()->getPrenomPart();
                    }
                }

                 if($telClient==null) $telClient='';
                $response = array("code" => 28,
                    "expeditions" => $results,
                    "codeClient" => $codeClient,
                    "date" => $date->format('Y-m-d'),
                    "telClient" => $telClient,
                    "client" => $client,
                        
                );
            return new Response(json_encode($response));
            }
          else {
        
            $response = array("codeError" => 40,
                    "message" => "Aucune expedition trouvée",);
            return new Response(json_encode($response));
        }
    }
    /**
     * Lists all Facture entities.
     * @Secure(roles="ROLE_ADD_FACTURE")
     */
    public function validerFactureAction(){
        
        $em = $this->getDoctrine()->getManager();
         
        $connection = $em->getConnection();
        $params = $this->getRequest()->request->all();
        $idExpeditions = $params['idExpeditions'];
        
        $totalTTC=0;
        $totalTVA=0;
        $totalHT=0;
        
        $client=null;
        $dataExpeditions=array();

        //get Client
        $exped=$em->getRepository("ComDaufinBundle:Expedition")->find($idExpeditions[0]);
        
            if($exped->getMdPort()=='portDu')
                $client=$exped->getRecClient();
            else
                $client=$exped->getEnvClient();
        // créer Facture
        $facture=new Facture();
        $facture->setDateCreation(new \DateTime());
        $facture->setStatutFacture("nonReglee");
        $facture->setClient($client);
        $facture->setEtatFacture("Modifiable");
        
        $em->persist($facture);
        
        foreach ($idExpeditions as $id) {
        
            $exped=$em->getRepository("ComDaufinBundle:Expedition")->find($id);
            
            if($exped->getFacture()!=null){
                $response = array("codeError" => 40,
                        "message" => "Expedition ".$exped->getCodeDeclaration()." est associée a la facture ".$exped->getFacture()->getNumFacture(),);
                return new Response(json_encode($response));
            }
             
            $exped->setFacture($facture);
            
            
            $suiviServices=$em->getRepository("ComDaufinBundle:SuivService")->findByExept($id);
            $totalExpTTC=0;
            $totalExpTVA=0;
            $totalExpHT=0;
             foreach ($suiviServices as $service){
                
                //$service=new SuivService();
                $totalExpHT+=$service->getPrixHt();
                $totalExpTTC+=$service->getPrixTtc();
                $totalExpTVA+=$service->getTva();
                 }
             $dataExpeditions[]=array_merge(array("declaration"=>$exped->getCodeDeclaration(),
                                      "agD"=>$exped->getEnvAgence(),
                                      "agA"=>$exped->getRecAgence(),
                                      "modePort"=>$exped->getMdPort(),
                                      "dateEnvoi"=>$exped->getDateDecl()->format("d-m-Y"),
                                      "montantHT"=>$totalExpHT,
                                      "montantTVA"=>$totalExpTVA,
                                      "montantTTC"=>$totalExpTTC,
              ));
             $totalTTC+=$totalExpTTC;
             $totalTVA+=$totalExpTVA;
             $totalHT+=$totalExpHT;
                
    }
        $facture->setTotalMontantHT($totalHT);
        $facture->setTotalMontantTTC($totalTTC);
        $facture->setTotalMontantTVA($totalTVA);
        
        $request = "SELECT   Fct_facture_insert() as numFacture";
        $statement = $connection->prepare($request);
        
        $statement->execute();
        $results = $statement->fetchAll();
        $numFacture=$results[0]['numFacture'];
        $facture->setNumFacture($numFacture);
         
         
     
        
   
        
//      $statement2 = $connection->prepare("select LIBELLE_VILLE as ville from ville v,agence a, affecter af 
//                                                where af.personnel=:client 
//                                                  AND af.agence=a.id 
//                                                  AND a.ville=v.id " );
//              $statement2->bindValue('client',$this->getUser()->getPersonnel()->getId());
//              $statement2->execute();
//              $results2 = $statement2->fetchAll();
                
         $em->flush();  
  
        $response = array( 
        		          "Message" => "Facture Créer avec Numéro: ".$facture->getNumFacture(),
                "statut" => "1",);
        
        return new Response(json_encode($response));
        
        
    }

    public function indexFacturesAction() {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ComDaufinBundle:Facture')->findAll();
        return $this->render('ComDaufinBundle:Facture:new.html.twig', array(
                    'entities' => $entities,

        ));
    }
    /**
     * Lists all Facture entities.
     * @Secure(roles="ROLE_SHOW_FACTURE")
     */
    public function showFactureAction($numFacture) {
        $em = $this->getDoctrine()->getManager();

        $connection = $em->getConnection();

        $entities = $em->getRepository('ComDaufinBundle:Facture')->find($numFacture);

        $request = "SELECT
				        e.id as id_exp,
		                code_Declaration as code_dec,
		                DATE_DECL as date_declaration,
		                env_date as Date_envoi,
		                rec_date as Date_rec,
		                (select a.libelle_ag from agence a where a.id=e.envAgence) as AgenceD,
		                (select a.libelle_ag from agence a where a.id=e.recAgence)  as AgenceR,
		                ETAT_EXP as statut,
		                POIDS_EXP as poid,
		                NBR_COLIS as nbColis,
		                md_port as mode,
		                sum(s.prix_HT) as ht,
		                sum(s.tva) as tva,
		                sum(s.prix_ttc) as ttc
             FROM expedition e
             join suiv_service as s on (e.id=s.exept)
            
             where e.id IN(select id from expedition where facture =:numFacture)
             group by e.code_Declaration";

        $statement = $connection->prepare($request);
        $statement->bindValue('numFacture', $numFacture);
        $statement->execute();
        $results = $statement->fetchAll();

        if (sizeof($results) >= 1) {
            $dateCreation = $entities->getDateCreation();
            $dateFacturation = $entities->getDateFacturation();
            $codeClient = $entities->getClient()->getCodeClient();
            $IDclient=$entities->getClient()->getId();
            if ($entities->getClient()->getTypeClient() == 'Compte') {
                $client = $entities->getClient()->getRSociale();
            } else {
                $client = $entities->getClient()->getNomPart() . ' ' . $entities->getClient()->getPrenomPart();
            }
            $telClient = $entities->getClient()->getTelClt();

            if ($telClient == null)
                $telClient = '';


            return $this->render('ComDaufinBundle:Facture:show.html.twig', array(
                        "entities" => $entities,
                        "expeditions" => $results,
                        "codeClient" => $codeClient,
                        "dateCreation" => $dateCreation->format('Y-m-d'),
                        "telClient" => $telClient,
                        "client" => $client,
                "IDclient" => $IDclient,
            ));
        }
        else {

            $response = array("codeError" => 27,
                "message" => "Aucune expedition trouvée",);
            return new Response(json_encode($response));
        }
    }

    public function EditerFactureAction()
    {
        $em = $this->getDoctrine()->getManager();

        $connection = $em->getConnection();

        $AllFactures = $em->getRepository('ComDaufinBundle:Facture')->findBy(array('etatFacture' => 'Modifiable'));
        $entitiesCompte = $em->getRepository('ComDaufinBundle:Client')->findBy(array('typeClient' => 'Compte'));
        $entitiesParticulier = $em->getRepository('ComDaufinBundle:Client')->findBy(array('typeClient' => 'Particulier'));

         return $this->render('ComDaufinBundle:Facture:edit.html.twig', array(
                    'AllFactures' => $AllFactures,
                    'entitiesCompte' => $entitiesCompte,
                    'entitiesParticulier' => $entitiesParticulier,
        ));
    }

    public function FindEditFactureAction()
    {
        $em = $this->getDoctrine()->getManager();

        $connection = $em->getConnection();
        $params = $this->getRequest()->request->all();
        $numFacture=$params['IDNumFacture'];

        $entities = $em->getRepository('ComDaufinBundle:Facture')->find($numFacture);

        $request = "SELECT
                e.id as id_exp,
                code_Declaration as code_dec,
                DATE_DECL as date_declaration,
                env_date as Date_envoi,
                rec_date as Date_rec,
                (select a.libelle_ag from agence a where a.id=e.envAgence) as AgenceD,
                (select a.libelle_ag from agence a where a.id=e.recAgence)  as AgenceR,
                ETAT_EXP as statut,
                POIDS_EXP as poid,
                NBR_COLIS as nbColis,
                md_port as mode,
                sum(s.prix_HT) as ht,
                sum(s.tva) as tva,
                sum(s.prix_ttc) as ttc
             FROM expedition e
             join suiv_service as s on (e.id=s.exept)
            
             where e.id IN(select id from expedition where facture =:numFacture)
             group by e.code_Declaration";

        $statement = $connection->prepare($request);
        $statement->bindValue('numFacture', $numFacture);
        $statement->execute();
        $results = $statement->fetchAll();

        if (sizeof($results) >= 1) {
            $dateCreation = $entities->getDateCreation();
            $dateFacturation = $entities->getDateFacturation();
            $codeClient = $entities->getClient()->getCodeClient();
            $IDclient=$entities->getClient()->getId();
            if ($entities->getClient()->getTypeClient() == 'Compte') {
                $client = $entities->getClient()->getRSociale();
            } else {
                $client = $entities->getClient()->getNomPart() . ' ' . $entities->getClient()->getPrenomPart();
            }
            $telClient = $entities->getClient()->getTelClt();

            if ($telClient == null)
                $telClient = '';

            $ht=$entities->getTotalMontantHT();
            $tva=$entities->getTotalMontantTVA();
            $ttc=$entities->getTotalMontantTTC();

           $response= array(
                        "ht" => $ht,
                        "tva" => $tva,
                        "ttc" => $ttc,
                        "expeditions" => $results,
                        "codeClient" => $codeClient,
                        "dateCreation" => $dateCreation->format('Y-m-d'),
                        "telClient" => $telClient,
                        "client" => $client,
                "IDclient" => $IDclient,
            );
            return new Response(json_encode($response));
        }
        else {

            $response = array("codeError" => 27,
                "message" => "Aucune expedition trouvée",);
            return new Response(json_encode($response));
        }
    }

    public function SaveEditFactureAction()
    {
        $em = $this->getDoctrine()->getManager();

        $connection = $em->getConnection();

        $params = $this->getRequest()->request->all();
        $idExpeditions = $params['idExpeditions'];
        $numFacture = $params['IDNumFacture'];

        $totalTTC = 0;
        $totalTVA = 0;
        $totalHT = 0;

        $facture=$em->getRepository('ComDaufinBundle:Facture')->find($numFacture);

        $totalTTC = $facture->getTotalMontantTTC();
        $totalTVA = $facture->getTotalMontantTVA();
        $totalHT = $facture->getTotalMontantHT();

        // $facture->setEtatFacture("Final"); 
        // default = Modifiable
        $em->flush();

        foreach ($idExpeditions as $id) {

            $exped = $em->getRepository("ComDaufinBundle:Expedition")->find($id);

            $exped->setFacture($facture);


            $suiviServices = $em->getRepository("ComDaufinBundle:SuivService")->findByExept($id);
            $totalExpTTC = 0;
            $totalExpTVA = 0;
            $totalExpHT = 0;
            foreach ($suiviServices as $service) {

                //$service=new SuivService();
                $totalExpHT+=$service->getPrixHt();
                $totalExpTTC+=$service->getPrixTtc();
                $totalExpTVA+=$service->getTva();
            }
            $totalTTC+=$totalExpTTC;
            $totalTVA+=$totalExpTVA;
            $totalHT+=$totalExpHT;
        }
        $facture->setTotalMontantHT($totalHT);
        $facture->setTotalMontantTTC($totalTTC);
        $facture->setTotalMontantTVA($totalTVA);

        $em->flush();

      
        $response = array('message' => "Votre facture a été modifiée avec succès",
        		          
        );
        return new Response(json_encode($response));
    }

    public function SaveEditDeleteFactureAction()
    {
        $em = $this->getDoctrine()->getManager();

        $connection = $em->getConnection();

        $params = $this->getRequest()->request->all();
        $idExpedition = $params['idExpedition'];
        $numFacture = $params['IDNumFacture'];

        $facture=$em->getRepository('ComDaufinBundle:Facture')->find($numFacture);

        // $facture->setEtatFacture("Final");
         // default = Modifiable
        $em->flush();

        $totalTTC = $facture->getTotalMontantTTC();
        $totalTVA = $facture->getTotalMontantTVA();
        $totalHT = $facture->getTotalMontantHT();
        

            $exped = $em->getRepository("ComDaufinBundle:Expedition")->find($idExpedition);

            $exped->setFacture(NULL);


            $suiviServices = $em->getRepository("ComDaufinBundle:SuivService")->findByExept($idExpedition);
            $totalExpTTC = 0;
            $totalExpTVA = 0;
            $totalExpHT = 0;
            foreach ($suiviServices as $service) {

                //$service=new SuivService();
                $totalExpHT+=$service->getPrixHt();
                $totalExpTTC+=$service->getPrixTtc();
                $totalExpTVA+=$service->getTva();
            }
            $totalTTC-=$totalExpTTC;
            $totalTVA-=$totalExpTVA;
            $totalHT-=$totalExpHT;

            if($totalHT<0)
            {
                $totalHT=0;
            }
            if($totalTVA<0)
            {
                $totalTVA=0;
            }
            if($totalTTC<0)
            {
                $totalTTC=0;
            }
        
        $facture->setTotalMontantHT($totalHT);
        $facture->setTotalMontantTTC($totalTTC);
        $facture->setTotalMontantTVA($totalTVA);

        $em->flush();

        $response = array('message' => "Votre facture a été modifiée avec succès", );
        return new Response(json_encode($response));
    }

    public function SaveEditEtatFactureAction()
    {
        $em = $this->getDoctrine()->getManager();

        $connection = $em->getConnection();

        $params = $this->getRequest()->request->all();
        $numFacture = $params['IDNumFacture'];

        $facture=$em->getRepository('ComDaufinBundle:Facture')->find($numFacture);

        $facture->setEtatFacture("Finale");
        $facture->setImpressionFacture("Originale");
         // default = Modifiable
        $em->flush();
        // $name=$this->imprimFacture($facture->getId());
        $response = array('message' => "Votre facture a été modifiée avec succès"
            //,"urlPDF" => "http://daufin.g-logmaroc.com/web/FacturesTaxation/".$name.".pdf"
        );
        return new Response(json_encode($response));
    }

    public function indexprintFactureAction()
    {
        $em = $this->getDoctrine()->getManager();

        $AllFactures = $em->getRepository('ComDaufinBundle:Facture')->findBy(array('etatFacture' => 'Finale'));

         return $this->render('ComDaufinBundle:Facture:print.html.twig', array(
                    'AllFactures' => $AllFactures,
        ));
    }
    public function PrintFactureAction()
    {
        $em = $this->getDoctrine()->getManager();

        $params = $this->getRequest()->request->all();
        $numFacture = $params['IDNumFacture'];

        $facture=$em->getRepository('ComDaufinBundle:Facture')->find($numFacture);

        if($facture->getImpressionFacture()=='Originale')
        {
            $name=$this->imprimFactureOriginal($facture->getId(),'');
            $response= array("urlPDF" => "http://daufin.g-logmaroc.com/web/FacturesTaxation/".$name.".pdf");
            $facture->setImpressionFacture("Duplicata");
            $em->flush();
        }
        else
        {
        	$name=$this->imprimFactureOriginal($facture->getId(),'Duplicata');
        	$response= array("urlPDF" => "http://daufin.g-logmaroc.com/web/FacturesTaxation/".$name.".pdf");
        }
        

        return new Response(json_encode($response));
    }
    private function imprimFactureOriginal($idFacture,$duplicata){
    	
    	$em = $this->getDoctrine()->getManager();
    	 
    	$facture=$em->getRepository('ComDaufinBundle:Facture')->find($idFacture);
    	
    	$totalTTC=0;
    	$totalTVA=0;
    	$totalHT=0;
    	$client=$facture->getClient();
    	
    	$dataExpeditions=array();
    	$expeditions=$em->getRepository("ComDaufinBundle:Expedition")->findByFacture($idFacture);
    	
    	foreach ($expeditions as $exped) {
    	    
    		$suiviServices=$em->getRepository("ComDaufinBundle:SuivService")->findByExept($exped->getId());
    		$totalExpTTC=0;
    		$totalExpTVA=0;
    		$totalExpHT=0;
    		foreach ($suiviServices as $service){
    	
    			//$service=new SuivService();
    			$totalExpHT+=$service->getPrixHt();
    			$totalExpTTC+=$service->getPrixTtc();
    			$totalExpTVA+=$service->getTva();
    		}
    		$dataExpeditions[]=array_merge(array("declaration"=>$exped->getCodeDeclaration(),
    				"agD"=>$exped->getEnvAgence(),
    				"agA"=>$exped->getRecAgence(),
    				"modePort"=>$exped->getMdPort(),
    				"dateEnvoi"=>$exped->getDateDecl()->format("d-m-Y"),
    				"montantHT"=>$totalExpHT,
    				"montantTVA"=>$totalExpTVA,
    				"montantTTC"=>$totalExpTTC,
    		));
    		$totalTTC+=$totalExpTTC;
    		$totalTVA+=$totalExpTVA;
    		$totalHT+=$totalExpHT;
    	
    	} 
    	
    	$nom=$facture->getClient()->__toString();
    	
    	
    	$date=new \DateTime();
    	$convert = explode('.',number_format($totalTTC, 2, '.', ''));
    	$txt=numfmt_create('fr_FR', \NumberFormatter::SPELLOUT)->format($convert[0]);
    	$txt.=' Dirhames';
    	if(isset($convert[1]) && $convert[1]!=''){
    		$txt.=' ,et ';
    		$txt.=numfmt_create('fr_FR', \NumberFormatter::SPELLOUT)->format($convert[1]);
    		$txt.=' Centimes';}
    	
    		$html = $this->renderView('ComDaufinBundle:Default:facture.html.twig', array(
    				'data'      => $dataExpeditions,
    				'facture'      => $facture,
    				'ville'      => "Casablanca",
    				//'ville'      => $results2[0]['ville'],
    				'dateNow'      => $date->format('d-m-Y'),
    				'totalTTC'      => $totalTTC,
    				'totalTVA'      => $totalTVA,
    				'totalHT'      => $totalHT,
    				'duplicata'      => $duplicata,
    				'montantLettre'      =>ucfirst($txt),
    				'codeClient'      => $client->getCodeClient(),
    				'nom'      => $nom,
    				'adresse'      => $client->getAdresseClt(),
    				'telClient'      => $client->getTelClt(),
    		));
    	
    		$name="Facture-".$facture->getNumFacture().$duplicata;
    	
    		$html2pdf = new \Html2Pdf_Html2Pdf('P','A4', 'fr', true, 'UTF-8', array(1, 2, 1, 1));
    		$html2pdf->pdf->SetDisplayMode('real');
    		$html2pdf->writeHTML($html);
    		$html2pdf->Output('FacturesTaxation/'.$name.'.pdf', 'F');
    		return $name;
    }

    public function exportAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $params = $this->getRequest()->request->all();
        $numFacture = $params['IDNumFacture'];

        $facture=$em->getRepository('ComDaufinBundle:Facture')->find($numFacture);

        $workbook = new Workbook();
        $workbook->setTitle('Liste des déclarations');
        $sheet = new Sheet($workbook);
        $table = new Table();
        $table1 = new Table();

        $table1->setRow([
            'Code Déclaration',
            'Agence Départ',
            'Agence Arrivée',
            'Mode Port',
            'Date Déclaration',
            'Montant HT',
            'Montant TVA',
            'Montant TTC',
            ]);
        $sheet->setRowHeight(20,1);

        $sheet->setColumnWidth(20,0);
        $sheet->setColumnWidth(20,1);
        $sheet->setColumnWidth(20,2);
        $sheet->setColumnWidth(20,3);
        $sheet->setColumnWidth(20,4);
        $sheet->setColumnWidth(20,5);
        $sheet->setColumnWidth(20,6);
        $sheet->setColumnWidth(20,7);

        $sheet->setDefaultRowHeight(18);

        $sheet->addTable($table1, new Coordinate(1, 1));
        $totalTTC=0;
        $totalTVA=0;
        $totalHT=0;
        
        
        $expeditions=$em->getRepository("ComDaufinBundle:Expedition")->findByFacture($numFacture);
        
        foreach ($expeditions as $exped) {
            
            $suiviServices=$em->getRepository("ComDaufinBundle:SuivService")->findByExept($exped->getId());
            $totalExpTTC=0;
            $totalExpTVA=0;
            $totalExpHT=0;
            foreach ($suiviServices as $service){
        
                //$service=new SuivService();
                $totalExpHT+=$service->getPrixHt();
                $totalExpTTC+=$service->getPrixTtc();
                $totalExpTVA+=$service->getTva();
            }
            
            $totalTTC+=$totalExpTTC;
            $totalTVA+=$totalExpTVA;
            $totalHT+=$totalExpHT;


            $table->setRow([
                $exped->getCodeDeclaration(),
                $exped->getEnvAgence(),
                $exped->getRecAgence(),
                $exped->getMdPort(),
                $exped->getDateDecl()->format("d-m-Y"),
                
                number_format($totalExpHT, 2, ',', ' '),
                number_format($totalExpTVA, 2, ',', ' '),
                number_format($totalExpTTC, 2, ',', ' '),
            ]);
        
        }
        $date=new \DateTime();
        $name="Facture-".$facture->getNumFacture()."-".$date->format('d-m-Y');

        $sheet->addTable($table, new Coordinate(1, 2));
        $workbook->addSheet($sheet);

        $writer = (new WriterFactory())->createWriter(new Excel5('ExportFactures/'.$name.'.xls'));
        $phpExcel = $writer->convert($workbook);
        $writer->write($phpExcel);

        $response= array("urlPDF" => "http://daufin.g-logmaroc.com/web/ExportFactures/".$name.".xls");
        return new Response(json_encode($response));
    }
}
