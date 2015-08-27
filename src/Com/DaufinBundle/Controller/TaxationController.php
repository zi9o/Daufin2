<?php

namespace Com\DaufinBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;

use Com\DaufinBundle\Entity\Expedition;
use Com\DaufinBundle\Form\ExpeditionType;
use Com\DaufinBundle\Entity\Personnel;
use Com\DaufinBundle\Entity\Crbt;
use Com\DaufinBundle\Entity\Client;
use Com\DaufinBundle\Form\CrbtType;
use Com\DaufinBundle\Form\PersonnelType;
use Com\DaufinBundle\Entity\Taxation;
use Com\DaufinBundle\Form\TaxationType;
use Com\DaufinBundle\Entity\OpererExpedition;
use Com\DaufinBundle\Entity\Cheque;
use Com\DaufinBundle\Entity\Traite;
use Com\DaufinBundle\Entity\BLivraisonM;
use Com\DaufinBundle\Entity\UniteManu;
use Com\DaufinBundle\Entity\SuivService;
use Com\DaufinBundle\Entity\Rubrique;
use Com\DaufinBundle\Entity\Secteur;
use Com\UserBundle\Entity\User;
//use Com\DaufinBundle\Entity\Stock;

//use Com\DaufinBundle\Entity\MouvementStock;


use Symfony\Component\HttpFoundation\Response;
use Com\DaufinBundle\Entity\Agence;


/**
 * Expedition controller.
 *
 */
class TaxationController extends Controller
{

    /**
     * Lists all Expedition entities.
     * @Secure(roles="ROLE_SHOW_ALL_TAXATION")
     */
    public function indexAction()
    {
    	
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ComDaufinBundle:Expedition')->findAll();

        return $this->render('ComDaufinBundle:Taxation:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Expedition entity.
     * @Secure(roles="ROLE_ADD_TAXATION")
     */
    public function createAction(Request $request)
    {
        $taxation = new Taxation();
        
        $crbt=new Crbt();
        $exped=new Client();
        $em = $this->getDoctrine()->getManager();
     
        $params = $this->getRequest()->request->all();

        $taxation=$params['com_daufinbundle_taxation'];
        // Les rubriques
        $isSimple=isset($params['activ_simple']);
        $isCrbt=isset($params['activ_crbt']);
        $isCheque=isset($params['activ_cheque']);
        $isTraite=isset($params['activ_traite']);
        $isBonLiv=isset($params['activ_bon_livr']);
        $isValDec=isset($params['activ_valeurDecl']);
                               
        $taxation=$params['com_daufinbundle_taxation'];
        $idRamasseur=$taxation['ramasseur'];
        $idReceptionneur= $taxation['receptionneur'];

        
        $idVilleExped=$taxation['villeExpediteur'];
        $idVilleDestin=$taxation['villeDestinataire'];
        
       $idAgenceTransit=$taxation['agenceTransit'];
        
        $idAgenceArrivee=$params['agenceDest'];        
        $idAgenceDepart=$params['agenceDepart'];        
        $codeDeclaration=$taxation['codeDeclaration'];
        
        $a=$em->getRepository('ComDaufinBundle:Expedition')->findOneByCodeDeclaration($codeDeclaration);
        
        if($a!=null){
        	echo "<script type='text/javascript'>alert('Le code déclaration ".$codeDeclaration." est deja Taxé');</script>";
        	return false;
        	
        }
        
        
        $modeExp=$taxation['modeExp'];
        $typeExp= $taxation['typeExp'];
        $nbreColis= $taxation['nbreColis'];
        $poids=$taxation['poids'];
        $volume=$taxation['volume'];
        
        if(isset($taxation['nbrePalettes']))
        	 $nbrePalettes= $taxation['nbrePalettes'];
        else 
        	$nbrePalettes=1;
        $montant=$taxation['montant'];
       
       
        $remarque=$taxation['remarque'];
        $typeLivraison=$taxation['typeLivraison'];
       
        
        // The Current User , Personnel, Agence

        
        

        // Objet Expedition
        $expedition =new Expedition();
        $expedition->setMdPort($modeExp);
        $expedition->setEtatRegl("nonReglee");
        $expedition->setTotalMontant($montant);
        $expedition->setNbrColis($nbreColis);
        $expedition->setPoidsExp($poids);
        $expedition->setNbrPalets($nbrePalettes);
        $expedition->setDateDecl(new \DateTime());
        $expedition->setEnvRemarque($remarque);
        $expedition->setVolumeExp($volume);
        $expedition->setTaxType($typeExp);
        $expedition->setTypeLivraison($typeLivraison);
        $expedition->setCodeDeclaration($codeDeclaration);
        
       	 if($isValDec)
       	 	 $expedition->setExpVal($taxation['valeurDecl']);
       
        
      
       	
       	//Parametre du Client 
       	$destinataire=null;
       	$expediteur=null;
       	
       	if(isset($params['typeClientExped']))
       		 $typeClientExped=$params['typeClientExped'];
       	else $typeClientExped='compte';
       	
       	if(isset($params['typeClientDest']))
       		$typeClientDest=$params['typeClientDest'];
       	else $typeClientDest='compte';
       	
       	
        if($idAgenceTransit=='') 	$expedition->setTypeTransit("Direct");
        else {
        	$expedition->setTypeTransit("Transit");
        	$agenceTransit = $em->getRepository('ComDaufinBundle:Agence')->find($idAgenceTransit);
        	 
        	$expedition->setAgenceTransit($agenceTransit);
            $expedition->setTransitVille($agenceTransit->getVille());
        	
        }

       	$agenceArrivee = $em->getRepository('ComDaufinBundle:Agence')->find($idAgenceArrivee);
       	$expedition->setRecAgence($agenceArrivee);
       	
       	//a ajouter agence depart with Admin Personnel And Agence
  
       	$agenceDepart = $em->getRepository('ComDaufinBundle:Agence')->find($idAgenceDepart);
     	$expedition->setEnvAgence($agenceDepart);
     	
     	
       	
       	
       	// pour expediteur
       	if($typeClientExped=="compte"){
       		
       		$idClientExped=$taxation['expediteur'];       	    
       		$expediteur = $em->getRepository('ComDaufinBundle:Client')->find($idClientExped);       		
       		$idSiteExped=$params['siteExped'];       		
       		$siteExped = $em->getRepository('ComDaufinBundle:Site')->find($idSiteExped);       		
       		$expedition->setEnvSecteur($siteExped->getSecteur());
       		$expedition->setEnvSite($siteExped);
       		 
       		
       	}else{
       		$telExped=$params['telExped'];
       		$adresseExped=$params['adresseExped'];
       		$clientExped=$params['clientExped'];
       		$secExp=null;
       		if(isset($params['secteurExped'])){
       			$secteurExped=$params['secteurExped'];
       			$secExp = $em->getRepository('ComDaufinBundle:Secteur')->find($secteurExped);
       		}
       		$expediteur=new Client();
       		$expediteur->setAdresseClt($adresseExped);
       		$expediteur->setNomPart($clientExped);
       		$expediteur->setTelClt($telExped);
       		$expediteur->setTypeClient("Particulier");
       		if($secExp!=null)
       			$expediteur->setSecteur($secExp);
       		
       		$em->persist($expediteur);
       		$expedition->setEnvSecteur($secExp);
       		
       }
       
       if($typeClientDest=="compte"){
       	 
         	$idClientDestin=$taxation['destinataire'];
        	$destinataire = $em->getRepository('ComDaufinBundle:Client')->find($idClientDestin);
       	 
	       	$idSiteDest=$params['siteDest'];
	       	$siteDest= $em->getRepository('ComDaufinBundle:Site')->find($idSiteDest);
	       	$expedition->setRecSecteur($siteDest->getSecteur());
	       	$expedition->setRecSite($siteDest);
	       
       }else{
        	$telDestin=$params['telDestin'];
       	 	$adresseDestin=$params['adresseDestin'];
        	$clientDestin=$params['clientDestin'];
         	$secDest=null;
       	  	 
       	if(isset($params['secteurDest'])){
       		$secteurDestin=$params['secteurDest'];
       		$secDest = $em->getRepository('ComDaufinBundle:Secteur')->find($secteurDestin);
       	}
       	 
        	$destinataire=new Client();
       	 
       	$destinataire->setAdresseClt($adresseDestin);
       	$destinataire->setNomPart($clientDestin);
       	$destinataire->setTelClt($telDestin);
       	$destinataire->setTypeClient("Particulier");
       	if($secDest!=null)
       		$destinataire->setSecteur($secDest);
       	  	$em->persist($destinataire);
        	$expedition->setRecSecteur($secDest);
       }
       	
       	
       	
        $entitieRama = $em->getRepository('ComDaufinBundle:Personnel')->find($idRamasseur);
        $entitieRecept = $em->getRepository('ComDaufinBundle:Personnel')->find($idReceptionneur);
              
        $expedition->setEnvClient($expediteur);
        $expedition->setRecClient($destinataire);
        
        $entitieVilleExped = $em->getRepository('ComDaufinBundle:Ville')->find($idVilleExped);
        $entitieVilleDestin = $em->getRepository('ComDaufinBundle:Ville')->find($idVilleDestin);        
            
       $expedition->setRecVille($entitieVilleDestin);  
       $expedition->setEnvVille($entitieVilleExped); 
       $expedition->setEtatExp("Taxation");
          

 
//        if($params['typeManut']=='Colis') {
//        	  $expedition->setTaxType("Colis");
//        	 // $expedition->setNbrPalets(1);
       	  
//        }else if($params['typeManut']=='Palettes'){ 

//              $expedition->setTaxType("Palettes");
//        }
       $em->persist($expedition);
       //Les Operations Sur Les Expeditions
       
       $operatioRamassage= new OpererExpedition();
       $operatioReception=new OpererExpedition();
       $operatioTaxation=new OpererExpedition();
        
       $operatioReception->setPersonnel($entitieRecept);
       $operatioReception->setDateOperation(new \DateTime());
       $operatioReception->setTypeOperation("Reception");
        
       $operatioRamassage->setPersonnel($entitieRama);
       $operatioRamassage->setDateOperation(new \DateTime());
       $operatioRamassage->setTypeOperation("Ramassage");
       
       /// Il faut changer cette personnel et associer le personnel authentifier
       
     
       
       $operatioTaxation->setPersonnel($this->getUser()->getPersonnel());
       $operatioTaxation->setDateOperation(new \DateTime());
       $operatioTaxation->setTypeOperation("Taxtion");
      
       $operatioRamassage->setExept($expedition);
       $operatioReception->setExept($expedition);
       $operatioTaxation->setExept($expedition);
       
       $em->persist($operatioTaxation);
       $em->persist($operatioReception);
       $em->persist($operatioRamassage);
       
            
       // ajout du Colis
       if($params['typeManut']=='Colis'){
       	
       	for ($i=0;$i<$nbreColis;$i++){
       		 
       		$entitUnitManu=new UniteManu();
       		$entitUnitManu->setTypeUnite("Colis");      		
       		//	$entitUnitManu->setVolumeUnite($volume);
       		$index='poidsColis'.$i;
       		 
       		if(isset($params[$index]))
       			$entitUnitManu->setPoidsUnite($params[$index]);
       		//	$entitUnitManu->setExept($expedition);
       		$entitUnitManu->setNbrColisPlt(1);
       		
       		$entitUnitManu->setExept($expedition);
       		$em->persist($entitUnitManu);
       		//$this->changeStock($expedition,$entitUnitManu);
       	}
       	
       	
       }
       // Ajout du Palettes
       else if($params['typeManut']=='Palettes'){
        for ($i=0;$i<$nbrePalettes;$i++){
            	
            	$entitUnitManu=new UniteManu();
            	$entitUnitManu->setTypeUnite("Palette");
            	$index='colisPalettes'.$i;       
            	$entitUnitManu->setNbrColisPlt($params[$index]);
            //	$entitUnitManu->setVolumeUnite($volume);
            //	$entitUnitManu->setPoidsUnite($poids);
            //	$entitUnitManu->setExept($expedition);
            
            	$entitUnitManu->setExept($expedition);
            	$em->persist($entitUnitManu);
            	//$this->changeStock($expedition,$entitUnitManu);
            	 
            }
       }
            	
            $objCrbt=new Crbt();
			$objCheque=new Cheque();
			$objTraite=new Traite();
			$objBonLivr=new BLivraisonM();
            	
				
            if(!$isSimple)
            	if($isCrbt){
            	$crbt= $taxation['crbt'];
            	
            	$objCrbt->setMontantCrbt($crbt);
            	$objCrbt->setExept($expedition);
            	$objCrbt->setEtatValid("nonValidee");
            	$em->persist($objCrbt);
            }if($isCheque){
            	$cheque=$taxation['cheque'];
            	
            	$objCheque->setMontantChq($cheque);
            	$objCheque->setExept($expedition);
            	$objCheque->setEtatValid("nonValidee");
            	$em->persist($objCheque);
            
            }if($isTraite){
            	$traite= $taxation['traite'];
            	
            	$objTraite->setMontantTrt($traite);
            	$objTraite->setExept($expedition);
            	$objTraite->setEtatValid("nonValidee");
            	$em->persist($objTraite);
            }if($isBonLiv){
            	$BnLivr= $taxation['cBonLivr'];
            	
				$objBonLivr->setNumBl($BnLivr);
            	$objBonLivr->setExept($expedition);
            	$objTraite->setEtatValid("nonValidee");
            	$em->persist($objBonLivr);
            }
            
       
            
            
            
        // TRacabilitee des Prix dans la table suivi Prix
        
            $prixTransport=$params['prixTransport'];
            $prixCheque=$params['prixCheque'];
            $prixTraite=$params['prixTraite'];
            $prixCrbt=$params['prixCrbt'];
            $prixRetourBL=$params['prixRetourBL'];
            $prixValorem=$params['prixValAD'];
            $prixLivraison=$params['prixLivraison'];
            $prixManut=$params['prixManut'];
            $prixLivGMS=$params['prixLivrGMS'];
            $prixEnregistrement=$params['prixEnrig'];
            $prixRamassage=$params['prixTaxeAvis'];
            $prixTaxeAvis=$params['prixRamassage'];
            
            
            
       // Tracabilite du TVA
            
            $tvaTransport=$params['tvaTransport'];
            $tvaCheque=$params['tvaCheque'];
            $tvaTraite=$params['tvaTraite'];
            $tvaCrbt=$params['tvaCrbt'];
            $tvaRetourBL=$params['tvaRetourBL'];
            $tvaValorem=$params['tvaValorem'];
            $tvaLivraison=$params['tvaLivraison'];
            $tvaManut=$params['tvaManut'];
            $tvaLivGMS=$params['tvaLivrGMS'];
            $tvaRamassage=$params['tvaRamassage'];
            $tvaTaxeAvis=$params['tvaTaxeAvis'];
            $tvaEnregistrement=$params['tvaEnrig'];
            
            
            
            
            //if($prixLivraison!==0){
            //retour Livr
            $suivPrix=new SuivService();
            $suivPrix->setExept($expedition);
            $rub=$em->getRepository("ComDaufinBundle:Rubrique")->find(2);
            $suivPrix->setRub($rub);
            $suivPrix->setPrixHt($prixLivraison);
            $suivPrix->setTva($tvaLivraison);
            $suivPrix->setPrixTtc($tvaLivraison+$prixLivraison);
            $suivPrix->setEtatReglement("nonReglee");
            $em->persist($suivPrix);
            
         //   }
            
         //   if($prixManut!=0){
            //Manut
            $suivPrix=new SuivService();
            $suivPrix->setExept($expedition);
            $rub=$em->getRepository("ComDaufinBundle:Rubrique")->find(12);
            $suivPrix->setRub($rub);
            $suivPrix->setPrixHt($prixManut);
            $suivPrix->setTva($tvaManut);
            $suivPrix->setPrixTtc($tvaManut+$prixManut);
            $suivPrix->setEtatReglement("nonReglee");
            $em->persist($suivPrix);
         //   }
          //  if($prixLivGMS!=0){
            //Liv GMS
            $suivPrix=new SuivService();
            $suivPrix->setExept($expedition);
            $rub=$em->getRepository("ComDaufinBundle:Rubrique")->find(6);
            $suivPrix->setRub($rub);
            $suivPrix->setPrixHt($prixLivGMS);
            $suivPrix->setTva($tvaLivGMS);
            $suivPrix->setPrixTtc($tvaLivGMS+$prixLivGMS);
            $suivPrix->setEtatReglement("nonReglee");
            $em->persist($suivPrix);
            
        //    }
         //   if($prixTransport!=0){
            //transport
            $suivPrix=new SuivService();
            $suivPrix->setExept($expedition);
            $rub=$em->getRepository("ComDaufinBundle:Rubrique")->find(13);
            $suivPrix->setRub($rub);
            $suivPrix->setPrixHt($prixTransport);
            $suivPrix->setTva($tvaTransport);
            $suivPrix->setPrixTtc($tvaTransport+$prixTransport);
            $suivPrix->setEtatReglement("nonReglee");
            $em->persist($suivPrix);
            
         //   }
         
          //  if($prixRetourBL!=0){
            //retour Retour BL
            $suivPrix=new SuivService();
            $suivPrix->setExept($expedition);
            $rub=$em->getRepository("ComDaufinBundle:Rubrique")->find(7);
            $suivPrix->setRub($rub);
            $suivPrix->setPrixHt($prixRetourBL);
            $suivPrix->setTva($tvaRetourBL);
            $suivPrix->setPrixTtc($tvaRetourBL+$prixRetourBL);
            $suivPrix->setEtatReglement("nonReglee");
            $em->persist($suivPrix);
         //   }
         //   if($prixValorem!=0){
            //Valorem
            $suivPrix=new SuivService();
            $suivPrix->setExept($expedition);
            $rub=$em->getRepository("ComDaufinBundle:Rubrique")->find(11);
            $suivPrix->setRub($rub);
            $suivPrix->setPrixHt($prixValorem);
            $suivPrix->setTva($tvaValorem);
            $suivPrix->setPrixTtc($tvaValorem+$prixValorem);
            $suivPrix->setEtatReglement("nonReglee");
            $em->persist($suivPrix);
          //  }
           // if($prixCheque!=0){
            
            //retour Cheque
            $suivPrix=new SuivService();
            $suivPrix->setExept($expedition);
            $rub=$em->getRepository("ComDaufinBundle:Rubrique")->find(8);
            $suivPrix->setRub($rub);
            $suivPrix->setPrixHt($prixCheque);
            $suivPrix->setTva($tvaCheque);
            $suivPrix->setPrixTtc($tvaCheque+$prixCheque);
            $suivPrix->setEtatReglement("nonReglee");
            $em->persist($suivPrix);
        //    }
        //    if($prixTraite!=0){
            //Traite
            $suivPrix=new SuivService();
            $suivPrix->setExept($expedition);
            $rub=$em->getRepository("ComDaufinBundle:Rubrique")->find(9);
            $suivPrix->setRub($rub);
            $suivPrix->setPrixHt($prixTraite);
            $suivPrix->setTva($tvaTraite);
            $suivPrix->setPrixTtc($tvaTraite+$prixTraite);
            $suivPrix->setEtatReglement("nonReglee");
            $em->persist($suivPrix);
         //   }
         //   if($prixCrbt!=0){
            //Crbt
            $suivPrix=new SuivService();
            $suivPrix->setExept($expedition);
            $rub=$em->getRepository("ComDaufinBundle:Rubrique")->find(10);
            $suivPrix->setRub($rub);
            $suivPrix->setPrixHt($prixCrbt);
            $suivPrix->setTva($tvaCrbt);
            $suivPrix->setPrixTtc($tvaCrbt+$prixCrbt);
            $suivPrix->setEtatReglement("nonReglee");
            $em->persist($suivPrix);
            
         //   }
            //RAMASSAGE
            $suivPrix=new SuivService();
            $suivPrix->setExept($expedition);
            $rub=$em->getRepository("ComDaufinBundle:Rubrique")->find(5);
            $suivPrix->setRub($rub);
            $suivPrix->setPrixHt($prixRamassage);
            $suivPrix->setTva($tvaRamassage);
            $suivPrix->setPrixTtc($tvaRamassage+$prixRamassage);
            $suivPrix->setEtatReglement("nonReglee");
            $em->persist($suivPrix);
            
            //Enregistrement
            $suivPrix=new SuivService();
            $suivPrix->setExept($expedition);
            $rub=$em->getRepository("ComDaufinBundle:Rubrique")->find(15);
            $suivPrix->setRub($rub);
            $suivPrix->setPrixHt($prixEnregistrement);
            $suivPrix->setTva($tvaEnregistrement);
            $suivPrix->setPrixTtc($tvaEnregistrement+$prixEnregistrement);
            $suivPrix->setEtatReglement("nonReglee");
            $em->persist($suivPrix);
            
            //Taxe Avis
            $suivPrix=new SuivService();
            $suivPrix->setExept($expedition);
            $rub=$em->getRepository("ComDaufinBundle:Rubrique")->find(14);
            $suivPrix->setRub($rub);
            $suivPrix->setPrixHt($prixTaxeAvis);
            $suivPrix->setTva($tvaTaxeAvis);
            $suivPrix->setPrixTtc($tvaTaxeAvis+$prixTaxeAvis);
            $suivPrix->setEtatReglement("nonReglee");
            $em->persist($suivPrix);
            
            
            
           
           $em->flush();
           
// 		   $connection = $em->getConnection();
//            $statement=$connection->prepare("call ChangeIDClient()");
//            $statement->execute();
//            //$idExped,$idCrbt,$idCheque,$idTraite,$idBonLivr,$idValDecl

            return $this->redirect($this->generateUrl('com_taxation_show', array('idExped' => $expedition->getId())));
        

    }

    /**
     * Creates a form to create a Expedition entity.
     *
     * @param Expedition $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Taxation $entity)
    {
        $form = $this->createForm(new TaxationType(), $entity, array(
            'action' => $this->generateUrl('com_taxation_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Expedition entity.
     * @Secure(roles="ROLE_ADD_TAXATION")
     */
    public function newAction()
    {
    	//list of Ramasseur & Destinataire
    	$em = $this->getDoctrine()->getManager();
    	
    	$ramasseur = $em->getRepository('ComDaufinBundle:Personnel')->findAll();
    	$receptionneur=$em->getRepository('ComDaufinBundle:Personnel')->findAll();
    	$destinataire=$em->getRepository('ComDaufinBundle:Client')->findByTypeClient("Compte");
    	$expediteur=$em->getRepository('ComDaufinBundle:Client')->findByTypeClient("Compte");
		$entitiesParticulier = $em->getRepository('ComDaufinBundle:Client')->findBy(array('typeClient' => 'Particulier'));
      $ClientParticulier='[';
      foreach ($entitiesParticulier as $value) {
          $ClientParticulier.=('"'.$value->getNomPart().'",');
      }
      $ClientParticulier.='" "]';
   // 	$villeExpediteur=$em->getRepository('ComDaufinBundle:Ville')->findAll();;
   // 	$villeDestinataire=$em->getRepository('ComDaufinBundle:Ville')->findAll();;
    	
        $entity = new Taxation();
        $entity->setRamasseur($ramasseur);
        $entity->setReceptionneur($receptionneur);
        $entity->setDestinataire($destinataire);
        $entity->setExpediteur($expediteur);
       // $entity;

        $user=$this->getUser();
        $personnel=$user->getPersonnel();
       
        $connection = $em->getConnection();
        
        $statement = $connection->prepare("SELECT ag.* FROM agence ag,affecter af
        		                           where af.personnel=:personnel AND
        		                                 af.agence=ag.id");
        $statement->bindValue('personnel', $personnel->getId());
        $statement->execute();
        $results = $statement->fetchAll();

        $form   = $this->createCreateForm($entity);
        

        return $this->render('ComDaufinBundle:Taxation:new.html.twig', array(
            'entity' => $entity,
			'entitiesParticulier' => $entitiesParticulier,
            'ClientParticulier'=>$ClientParticulier,
        	'agence' => $results[0],
            'form'   => $form->createView(),
        ));
    }
    /**
     * 
     **/
 
    public function newForfaitAction()
    {
    	//list of Ramasseur & Destinataire
    	$em = $this->getDoctrine()->getManager();
    	 
    	$ramasseur = $em->getRepository('ComDaufinBundle:Personnel')->findAll();
    	$receptionneur=$em->getRepository('ComDaufinBundle:Personnel')->findAll();
    	$destinataire=$em->getRepository('ComDaufinBundle:Client')->findByTypeClient("Compte");
    	$expediteur=$em->getRepository('ComDaufinBundle:Client')->findByTypeClient("Compte");
      $entitiesParticulier = $em->getRepository('ComDaufinBundle:Client')->findBy(array('typeClient' => 'Particulier'));
      $ClientParticulier='[';
      foreach ($entitiesParticulier as $value) {
          $ClientParticulier.=('"'.$value->getNomPart().'",');
      }
      $ClientParticulier.='" "]';
    	// 	$villeExpediteur=$em->getRepository('ComDaufinBundle:Ville')->findAll();;
    	// 	$villeDestinataire=$em->getRepository('ComDaufinBundle:Ville')->findAll();;
    	 
    	$entity = new Taxation();
    	$entity->setRamasseur($ramasseur);
    	$entity->setReceptionneur($receptionneur);
    	$entity->setDestinataire($destinataire);
    	$entity->setExpediteur($expediteur);
    	// $entity;
    
    	$user=$this->getUser();
    	$personnel=$user->getPersonnel();
    	 
    	$connection = $em->getConnection();
    
    	$statement = $connection->prepare("SELECT ag.* FROM agence ag,affecter af
        		                           where af.personnel=:personnel AND
        		                                 af.agence=ag.id");
    	$statement->bindValue('personnel', $personnel->getId());
    	$statement->execute();
    	$results = $statement->fetchAll();
    
    	$form   = $this->createCreateForm($entity);
    
    
    	return $this->render('ComDaufinBundle:Taxation:newForfait.html.twig', array(
    			'entity' => $entity,
    			'agence' => $results[0],
          'entitiesParticulier' => $entitiesParticulier,
            'ClientParticulier'=>$ClientParticulier,
    			'form'   => $form->createView(),
    	));
    }

    /**
     * Finds and displays a Expedition entity.
     * @Secure(roles="ROLE_SHOW_TAXATION")
    
     */
    public function showAction($idExped)
    {
        $em = $this->getDoctrine()->getManager();

        $entityExped = $em->getRepository('ComDaufinBundle:Expedition')->find($idExped);

        if (!$entityExped) {
        	throw $this->createNotFoundException('Unable to find Expedition entity.');
        }
		$entities = $em->getRepository('ComDaufinBundle:Crbt')
						->createQueryBuilder('c')
						->join('c.exept', 'e')
						->where('e.id= '.$idExped)
						->getQuery()->getArrayResult();
		
		if (sizeof($entities) >=1) $entityCrbt=$entities[0];
		 else $entityCrbt=null;
		 
		 $entities = $em->getRepository('ComDaufinBundle:Cheque')
		 ->createQueryBuilder('c')
		 ->join('c.exept', 'e')
		 ->where('e.id= '.$idExped)
		 ->getQuery()->getArrayResult();
		 
		 if (sizeof($entities) >=1) $entityCheque=$entities[0];
		 else $entityCheque=null;
		
		 $entities = $em->getRepository('ComDaufinBundle:Traite')
		 ->createQueryBuilder('c')
		 ->join('c.exept', 'e')
		 ->where('e.id= '.$idExped)
		 ->getQuery()->getArrayResult();
		 	
		 if (sizeof($entities) >=1) $entityTraite=$entities[0];
		 else $entityTraite=null;
		 
	
		 $entities = $em->getRepository('ComDaufinBundle:BLivraisonM')
		 ->createQueryBuilder('c')
		 ->join('c.exept', 'e')
		 ->where('e.id= '.$idExped)
		 ->getQuery()->getArrayResult();
		 	
		 if (sizeof($entities) >=1) $entityBonLivr=$entities[0];
		 else $entityBonLivr=null;
		 
		 //nombre de colis
		 $entities = $em->getRepository('ComDaufinBundle:UniteManu')
		 ->createQueryBuilder('c')
		 ->join('c.exept', 'e')
		 ->where('e.id= '.$idExped)
		 ->getQuery()->getArrayResult();
		 
		 if (sizeof($entities) >=1){
		 	if($entities[0]['typeUnite']=="Palette"){
		 		
		 		$nbreTicket=$entityExped->getNbrPalets();
		 		
		 	}else{
		 		$nbreTicket=$entityExped->getNbrColis();
		 	}		 
		  
		  
		 }
		 else $nbreTicket=0;
      

        $deleteForm = $this->createDeleteForm($idExped);
        
        $prixTransport=0;
        $prixCheque=0;
        $prixTraite=0;
        $prixCrbt=0;
        $prixRetourBL=0;
        $prixValorem=0;
        $prixLivraison=0;
        $prixManut=0;
        $prixLivGMS=0;
        $prixEnregistrement=0;
        $prixRamassage=0;
        $prixTaxeAvis=0;
        
        $idServiceTransport;
        $idServiceRetourBL;
        $idServiceValorem;
        $idServiceLivraison;
        $idServiceManut;
        $idServiceLivGMS;
        $idServiceEnregistrement;
        $idServiceRamassage;
        $idServiceTaxeAvis;
        $idServiceCheque;
        $idServiceTraite;
        $idServiceCRBT;
        
        
        $tvaTransport=0;
        $tvaCheque=0;
        $tvaTraite=0;
        $tvaCrbt=0;
        $tvaRetourBL=0;
        $tvaValorem=0;
        $tvaLivraison=0;
        $tvaManut=0;
        $tvaLivGMS=0;
        $tvaRamassage=0;
        $tvaTaxeAvis=0;
        $tvaEnregistrement=0;
        $connection = $em->getConnection();
        
        $statement = $connection->prepare("SELECT s.id,s.prix_ht,s.tva,s.prix_ttc,s.rub,r.LIBELLE_RUB
				                         FROM suiv_service s, rubrique r
				                          where s.exept=:idExped AND s.rub=r.id
                                           ");
        $statement->bindValue('idExped',$idExped);
        $statement->execute();
        $results = $statement->fetchAll();
        
        foreach ($results as $res){
        	if($res['rub']==2){
        		$prixLivraison=$res['prix_ht'];
        		$tvaLivraison=$res['tva'];
        		$idServiceLivraison=$res['id'];
        	}
        	else if($res['rub']==12){
        		$prixManut=$res['prix_ht'];
        		$tvaManut=$res['tva'];
        		$idServiceManut=$res['id'];
        	}
        	else if($res['rub']==6){
        		$prixLivGMS=$res['prix_ht'];
        		$tvaLivGMS=$res['tva'];
        		$idServiceLivGMS=$res['id'];
        	}
        	else if($res['rub']==13){
        		$prixTransport=$res['prix_ht'];
        		$tvaTransport=$res['tva'];
        		$idServiceTransport=$res['id'];
        	}
        	else if($res['rub']==7){
        		$prixRetourBL=$res['prix_ht'];
        		$tvaRetourBL=$res['tva'];
        		$idServiceRetourBL=$res['id'];
        	}
        	else if($res['rub']==11){
        		$prixValorem=$res['prix_ht'];
        		$tvaValorem=$res['tva'];
        		$idServiceValorem=$res['id'];
        	}
        	else if($res['rub']==8){
        		$prixCheque=$res['prix_ht'];
        		$tvaCheque=$res['tva'];
        		$idServiceCheque=$res['id'];
        	}
        	else if($res['rub']==9){
        		$prixTraite=$res['prix_ht'];
        		$tvaTraite=$res['tva'];
        		$idServiceTraite=$res['id'];
        	}
        	else if($res['rub']==10){
        		$prixCrbt=$res['prix_ht'];
        		$tvaCrbt=$res['tva'];
        		$idServiceCRBT=$res['id'];
        	}
        	else if($res['rub']==5){
        		$prixRamassage=$res['prix_ht'];
        		$tvaRamassage=$res['tva'];
        		$idServiceRamassage=$res['id'];
        	}else if($res['rub']==14){
        		$prixTaxeAvis=$res['prix_ht'];
        		$tvaTaxeAvis=$res['tva'];
        		 $idServiceTaxeAvis=$res['id'];
        	}else if($res['rub']==15){
        		$prixEnregistrement=$res['prix_ht'];
        		$tvaEnregistrement=$res['tva'];
        		 $idServiceEnregistrement=$res['id'];
        	}
        	
        		
        		
        }
        
        $montantHT=$prixTransport+$prixCheque+$prixCrbt+$prixTraite+$prixRetourBL+$prixValorem+$prixLivraison+$prixLivGMS+$prixRamassage+$prixEnregistrement+$prixManut+$prixTaxeAvis;
        $sommeTVA=$tvaTransport+$tvaCheque+$tvaCrbt+$tvaTraite+$tvaRetourBL+$tvaValorem+$tvaLivraison+$tvaLivGMS+$tvaRamassage+$tvaEnregistrement+$tvaTaxeAvis+$tvaManut;
        $montantTTC=$montantHT+$sommeTVA;
        
        

        return $this->render('ComDaufinBundle:Taxation:show.html.twig', array(
            'entityExped'      => $entityExped,
			'entityCrbt'      => $entityCrbt,
			'entityCheque'      => $entityCheque,
			'entityTraite'      => $entityTraite,
			'entityBonLivr'      => $entityBonLivr,
        	'nbreTickets' =>$nbreTicket,	
        		"prixCrbt" =>  $prixCrbt,
        		"prixVAlorem" =>  $prixValorem,
        		"prixLivraison"=>$prixLivraison,
        		"prixManut" => $prixManut,
        		"prixLivrGMS" => $prixLivGMS,
        		"prixEnrig" =>  $prixEnregistrement,
        		"prixTaxeAvis"=>$prixTaxeAvis,
        		"prixRamassage"=>$prixRamassage,
        		"prixTransport"=>$prixTransport,
        		"prixTraite"=>$prixTraite,
        		"prixCheque"=>$prixCheque,
        		"prixBL"=>$prixRetourBL,
	     	 	
        		"idServiceCrbt" =>  $idServiceCRBT,
        		"idServiceVAlorem" =>  $idServiceValorem,
        		"idServiceLivraison"=>$idServiceLivraison,
        		"idServiceManut" => $idServiceManut,
        		"idServiceLivrGMS" => $idServiceLivGMS,
        		"idServiceTransport"=>$idServiceTransport,
        		
        		"idServiceEnrig"=>$idServiceEnregistrement,
        		"idServiceCheque"=>$idServiceCheque,
        		"idServiceTraite"=>$idServiceTraite,
        		"idServiceBL"=>$idServiceRetourBL,
        		"idServiceLivraison"=>$idServiceLivraison,
        		"idServiceTaxeAvis"=> $idServiceTaxeAvis,
        		"idServiceRamassage"=>$idServiceRamassage,
        		 
        		
        		"autreFrais"=>$prixManut+$prixLivGMS,
        		"prixBL" =>  $prixRetourBL,
        		"retourFond" =>  $prixCheque+$prixCrbt+$prixTraite,
        		"montatHT" =>  $montantHT,
        		"montantTTC"=>$montantTTC,
        		"tva"=>$sommeTVA,       		
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Expedition entity.
     * @Secure(roles="ROLE_EDIT_TAXATION")
    
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:Expedition')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Expedition entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ComDaufinBundle:Taxation:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Expedition entity.
    *
    * @param Expedition $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Expedition $entity)
    {
        $form = $this->createForm(new ExpeditionType(), $entity, array(
            'action' => $this->generateUrl('com_taxation_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Expedition entity.
     * @Secure(roles="ROLE_EDIT_TAXATION")
    
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:Taxation')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Expedition entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('com_taxation_edit', array('id' => $id)));
        }

        return $this->render('ComDaufinBundle:Taxation:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Expedition entity.
     * @Secure(roles="ROLE_DELETE_TAXATION")
    
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ComDaufinBundle:Taxation')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Expedition entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('com_taxation'));
    }

    /**
     * Creates a form to delete a Expedition entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('com_taxation_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
    
    /**
     * Edits an existing Expedition entity.
     * @Secure(roles="ROLE_ADD_TAXATION")
    
     */
    
    public function calculMontantForfaitAction(){
    
    	$params = $this->getRequest()->request->all();
    
    	 
    	$idClientExped=$params['idClientExped'];
    	$idClientDestin=$params['idClientDestin'];
    	$idVilleExped=$params['idVilleExped'];
    	$idVilleDestin=$params['idVilleDestin'];
    	$modeExp=$params['modeExp'];
    	$typeExped=$params['typeExp'];
    	$typeLivr=$params['typeLivr'];
    
    	if(isset($params['isFragile']))
    		$isFragile=true;
    	else  $isFragile=false;
    	 
    	$nbreColis=$params['nbreColis'];
    	$nbrePalettes=$params['nbrePalettes'];
    	$volume=$params['volume'];
    	$poids=$params['poids'];
    	$poidsColis=json_decode(stripslashes($params['poidsColis']));
    	 
    	$crbt=$params['crbt'];
    	$cheque=$params['cheque'];
    	$traite=$params['traite'];
    	$bonLiv=$params['bonLiv'];
    	$valDec=$params['valDec'];
    
    
    	$idRubTransport=1;
    	$idRubCheque=8;
    	$idRubTraite=9;
    	$idRubCrbt=10;
    	$idRubFragile=17;
    	$idrubBL=7;
    	$idRubValeur=11;
    	$idRubLivr=2;
    	$idrubManut=12;
    	$idrubLivGMS=6;
    	$idrubRamassage=5;
    	$idrubTaxeAvis=14;
    	$idrubEnregistrement=15;
    
    	// prix HT
    	$prixTransport=0;
    	$prixCheque=0;
    	$prixTraite=0;
    	$prixCrbt=0;
    	$prixRetourBL=0;
    	$prixValorem=0;
    	$prixLivraison=0;
    	$prixManut=0;
    	$prixLivGMS=0;
    	$prixEnregistrement=0;
    	$prixRamassage=0;
    	$prixTaxeAvis=0;
    
    	// TVA
    	$tvaTransport=0;
    	$tvaCheque=0;
    	$tvaTraite=0;
    	$tvaCrbt=0;
    	$tvaRetourBL=0;
    	$tvaValorem=0;
    	$tvaLivraison=0;
    	$tvaManut=0;
    	$tvaLivGMS=0;
    	$tvaRamassage=0;
    	$tvaTaxeAvis=0;
    	$tvaEnregistrement=0;
    
    	$sommeTVA=0.0;
    	$sommeHT=0.0;
    
    
    	$em = $this->getDoctrine()->getEntityManager();
    	$connection = $em->getConnection();
    
    	$statement = $connection->prepare("SELECT id FROM sous_trajet s WHERE
	     		                           s.ville_depart= :idVilleDepart AND s.ville_arrivee= :idVilleArrivee");
    	$statement->bindValue('idVilleDepart', $idVilleExped);
    	$statement->bindValue('idVilleArrivee', $idVilleDestin);
    	$statement->execute();
    	$results = $statement->fetchAll();
    
    
    	if(sizeof($results)>=1){
    		$en1=$results[0];
    		$idtrajet=$en1['id'];
    	}
    	else {
    		$error = array("error" => "Le Trajet selectionne n'existe pas.",
    				"codeError"=>13,);
    		return new Response(json_encode($error));
    	}
    
     
    
    	 
    		 
    		// Recuperation du Id Contrat
    		$idContrat;
    		$statement = $connection->prepare("SELECT id FROM contrat c where
    											 c.client= :idClient AND
     											 c.etat_contart=\"Activee\" ");
    		$statement->bindValue('idClient', $idClientExped);
    		$statement->execute();
    		$results = $statement->fetchAll();
    		if(sizeof($results)>=1){
    			$en1=$results[0];
    			$idContrat=$en1['id'];
    		}
    		else {
    			$error = array("error" => "Le Client ne déspose d'aucune contrat Active.",
    					"codeError"=>14,);
    			return new Response(json_encode($error));
    		}
    		
    		//recuperer le prix du tranche 1---X
    		$prixForfait=0;
    		$maxPoidsForfait=0;
    		$tvaForfaitTransport=0;
    		$prixKgSupp=0;
    		
    		$statement = $connection->prepare("SELECT VALEUR_MIN,VALEUR_MAX,TVA,VALEUR,tv.max_type,tv.Min_min 
    				                            FROM cont_table_prix, type_valeur tv WHERE
			     		                            cont_table_prix.id_rub= :idrub AND
			 	       	 							
			     									cont_table_prix.etat='Activee' AND
													cont_table_prix.ID_CONTART= :idContrat AND
    												cont_table_prix.ID_T_Val=tv.id AND	
			     		                            tv.LIBELLE_T_VAL like \"%Forfait poid%\"");
    		$statement->bindValue('idrub', $idRubTransport);
    		$statement->bindValue('idContrat', $idContrat);
    		//$statement->bindValue('idtrajet', $idtrajet); cont_table_prix.ID_S_TRAJET= :idtrajet AND
    	 
    		$statement->execute();
    		$results = $statement->fetchAll();
    		
    		if(sizeof($results)>=1){
    			$en1=$results[0];
    			$prixForfait=$en1['VALEUR'];
    			$maxPoidsForfait=$en1['max_type'];
    			$tvaForfaitTransport=$en1['TVA'];
    			
    		}else{
    			$error = array("error" => "Les Detaits du forfait ne sont pas specifier à cette contrat.",
    					"codeError"=>14,);
    			return new Response(json_encode($error));
    		}
    		
    		//echo $prixForfait.'/'.$maxPoidsForfait.'/'.$tvaForfaitTransport;
    		// Recupper le prix pour chaque kg SUupp
    		
    		$statement = $connection->prepare("SELECT VALEUR_MIN,VALEUR_MAX,TVA,VALEUR,tv.max_type,tv.Min_min
    				                            FROM cont_table_prix, type_valeur tv WHERE
			     		                            cont_table_prix.id_rub= :idrub AND
			 	       	 							
			     									cont_table_prix.etat='Activee' AND
													cont_table_prix.ID_CONTART= :idContrat AND
    												cont_table_prix.ID_T_Val=tv.id AND
			     		                            tv.LIBELLE_T_VAL like \"%Poids Supp%\"");
    		$statement->bindValue('idrub', $idRubTransport);
    		$statement->bindValue('idContrat', $idContrat);
    		//$statement->bindValue('idtrajet', $idtrajet); cont_table_prix.ID_S_TRAJET= :idtrajet AND
    		
    		$statement->execute();
    		$results = $statement->fetchAll();
    		
    		if(sizeof($results)>=1){
    			$en1=$results[0];
    			$prixKgSupp=$en1['VALEUR'];   			 
    		}else{
    			$error = array("error" => "Les Detaits du forfait ne sont pas specifier à cette contrat.",
    					"codeError"=>14,);
    			return new Response(json_encode($error));
    		}
    	 for($i=0;$i<sizeof($poidsColis);$i++){
     
    		if($poidsColis[$i]<=$maxPoidsForfait)
    			$prixTransport+=$prixForfait;
    		else {
    			$a=$poidsColis[$i]-$maxPoidsForfait;
    			 
    			
    			$prixTransport+=($a*$prixKgSupp)+$prixForfait;
    			 
    		}
    		
    		
    	}
    	
    	$tvaTransport=($prixTransport*$tvaForfaitTransport)/100;
    	$sommeTVA=$sommeTVA+$tvaTransport;
    		 
    		//Montant Cheque
    		if(!empty($cheque)){
    
    			$statement = $connection->prepare("SELECT VALEUR_MIN,VALEUR_MAX,TVA,VALEUR FROM cont_table_prix, type_valeur tv WHERE
			     		                            cont_table_prix.id_rub= :idrub AND
			 	       	 							 cont_table_prix.ID_S_TRAJET= :idtrajet AND
													cont_table_prix.etat='Activee' AND
			 	       	 							cont_table_prix.ID_CONTART= :idContrat AND
			     		                            cont_table_prix.ID_T_VAL=tv.id AND
			 	       	 							tv.LIBELLE_T_VAL like \"%cheque%\"");
    			$statement->bindValue('idrub', $idRubCheque);
    			$statement->bindValue('idContrat', $idContrat);
    			$statement->bindValue('idtrajet', $idtrajet);
    
    			$statement->execute();
    			$results = $statement->fetchAll();
    			if(sizeof($results)>=1){
    				$en1=$results[0];
    				$val=$en1['VALEUR']*$cheque;
    
    				if($val<$en1['VALEUR_MIN'])    $prixCheque=$en1['VALEUR_MIN'];
    				else if($val>$en1['VALEUR_MAX'])  $prixCheque=$en1['VALEUR_MAX'];
    				else  $prixCheque=$val;
    				$tvaCheque=($prixCheque*$en1['TVA'])/100;
    				$sommeTVA=$sommeTVA+$tvaCheque;
    			}
    		}
    
    		//Montant Crbt
    
    		if(!empty($crbt)){
    			$statement = $connection->prepare("SELECT VALEUR_MIN,VALEUR_MAX,TVA,VALEUR FROM cont_table_prix, type_valeur tv WHERE
				     		                            cont_table_prix.id_rub= :idrub AND
			 	       	 							    cont_table_prix.ID_S_TRAJET= :idtrajet AND
														cont_table_prix.etat='Activee' AND
			 	       	 			                    cont_table_prix.ID_CONTART= :idContrat AND
				     		                            cont_table_prix.ID_T_VAL=tv.id AND
			 	       	 			                    tv.LIBELLE_T_VAL like \"%Crbt%\"");
    			$statement->bindValue('idrub', $idRubCrbt);
    			$statement->bindValue('idtrajet', $idtrajet);
    			$statement->bindValue('idContrat', $idContrat);
    
    			$statement->execute();
    			$results = $statement->fetchAll();
    			if(sizeof($results)>=1){
    				$en2=$results[0];
    				$val=$en2['VALEUR']*$crbt;
    				 
    				if($val<=$en2['VALEUR_MIN'])    $prixCrbt=$en2['VALEUR_MIN'];
    				else  $prixCrbt=$val;
    				$tvaCrbt=($prixCrbt*$en2['TVA'])/100;
    				$sommeTVA=$sommeTVA+$tvaCrbt;
    
    			}
    		}
    		//Montant Traite
    
    		if(!empty($traite)){
    			$statement = $connection->prepare("SELECT VALEUR_MIN,VALEUR_MAX,TVA,VALEUR FROM cont_table_prix, type_valeur tv WHERE
					     		                            cont_table_prix.id_rub= :idrub AND
			 	       	 			 						cont_table_prix.ID_S_TRAJET= :idtrajet AND
															cont_table_prix.etat='Activee' AND
			 	       	 									cont_table_prix.ID_CONTART= :idContrat AND
					     		                            cont_table_prix.ID_T_VAL=tv.id AND
			 	       	 									tv.LIBELLE_T_VAL like \"%traite%\"");
    			$statement->bindValue('idrub', $idRubTraite);
    			$statement->bindValue('idtrajet', $idtrajet);
    			$statement->bindValue('idContrat', $idContrat);
    
    			$statement->execute();
    			$results = $statement->fetchAll();
    			if(sizeof($results)>=1){
    				$en1=$results[0];
    				$val=$en1['VALEUR']*$traite;
    
    				if($val<=$en1['VALEUR_MIN'])    $prixTraite=$en1['VALEUR_MIN'];
    				else if($val>=$en1['VALEUR_MAX'])  $prixTraite=$en1['VALEUR_MAX'];
    				else  $prixTraite=$val;
    				 
    				$tvaTraite=($prixTraite*$en1['TVA'])/100;
    				$sommeTVA=$sommeTVA+$tvaTraite;
    			}
    		}
    		//Montant Retour BL
    		 
    		if(!empty($bonLiv)){
    			$statement = $connection->prepare("SELECT VALEUR_MIN,VALEUR_MAX,TVA,VALEUR FROM cont_table_prix, type_valeur tv WHERE
				     		                            cont_table_prix.id_rub= :idrub AND
			 	       	 			                    cont_table_prix.ID_S_TRAJET= :idtrajet AND
														cont_table_prix.etat='Activee' AND
			 	       	 								cont_table_prix.ID_CONTART= :idContrat AND
				     		                            cont_table_prix.ID_T_VAL=tv.id AND
			 	       	 								tv.LIBELLE_T_VAL like \"%Retour BL%\"");
    			$statement->bindValue('idrub', $idrubBL);
    
    			$statement->bindValue('idContrat', $idContrat);
    			$statement->bindValue('idtrajet', $idtrajet);
    
    			$statement->execute();
    			$results = $statement->fetchAll();
    			if(sizeof($results)>=1){
    				$en1=$results[0];
    				$prixRetourBL=$en1['VALEUR'];
    				$tvaRetourBL=($prixRetourBL*$en1['TVA'])/100;
    				$sommeTVA=$sommeTVA+$tvaRetourBL;
    			}
    		}
    
    		// AD Valorem
    
    		if(!empty($valDec)){
    			$statement = $connection->prepare("SELECT VALEUR_MIN,VALEUR_MAX,TVA,VALEUR FROM cont_table_prix, type_valeur tv WHERE
					     		                            cont_table_prix.id_rub= :idrub AND
			 	       	 									cont_table_prix.ID_S_TRAJET= :idtrajet AND
															cont_table_prix.etat='Activee' AND
			 	       	 			  						cont_table_prix.ID_CONTART= :idContrat AND
					     		                            cont_table_prix.ID_T_VAL=tv.id AND
			 	       	 									tv.LIBELLE_T_VAL like \"%valeur%\"");
    			$statement->bindValue('idrub', $idRubValeur);
    
    			$statement->bindValue('idContrat', $idContrat);
    			$statement->bindValue('idtrajet', $idtrajet);
    
    			$statement->execute();
    			$results = $statement->fetchAll();
    			if(sizeof($results)>=1){
    				$en1=$results[0];
    				$val=$en1['VALEUR']*$valDec;
    
    				if($val<=$en1['VALEUR_MIN'])    $prixValorem=$en1['VALEUR_MIN'];
    				else  $prixValorem=$val;
    				$tvaValorem=($prixValorem*$en1['TVA'])/100;
    				$sommeTVA=$sommeTVA+$tvaValorem;
    
    			}
    
    		}
    
    		/// Livraison (domicile o gare=0 )
    		if(strpos($typeLivr,'gare') !== false){$prixLivraison=0;}
    		else {
    
    			$statement = $connection->prepare("SELECT VALEUR_MIN,VALEUR_MAX,TVA,VALEUR FROM cont_table_prix, type_valeur tv WHERE
					     		                            cont_table_prix.id_rub= :idrub AND
			 	       	 			 						cont_table_prix.ID_S_TRAJET= :idtrajet AND
															cont_table_prix.etat='Activee' AND
			 	       	 									cont_table_prix.ID_CONTART= :idContrat AND
					     		                            cont_table_prix.ID_T_VAL=tv.id AND
			 	       	 									tv.LIBELLE_T_VAL like \"%domicile%\"");
    			$statement->bindValue('idrub', $idRubLivr);
    			$statement->bindValue('idtrajet', $idtrajet);
    
    			$statement->bindValue('idContrat', $idContrat);
    
    			$statement->execute();
    			$results = $statement->fetchAll();
    			if(sizeof($results)>=1){
    				$en1=$results[0];
    				//		$val=$en1['VALEUR']*$valDec;
    				 
    				//if($val<=$en1['VALEUR_MIN'])
    				$prixLivraison=$en1['VALEUR_MIN'];
    				//		else  $prixLivraison=$val;
    				$tvaLivraison=($prixLivraison*$en1['TVA'])/100;
    				$sommeTVA=$sommeTVA+$tvaLivraison;
    				 
    			}
    
    		}
    
    		//Calcul Livraison GMS
    		$statement = $connection->prepare("SELECT VALEUR_MIN,VALEUR_MAX,TVA,VALEUR FROM cont_table_prix, type_valeur tv WHERE
					     		                            cont_table_prix.id_rub= :idrub AND
			 	       	 									cont_table_prix.ID_S_TRAJET= :idtrajet AND
															cont_table_prix.etat='Activee' AND
			 	       	 									cont_table_prix.ID_CONTART= :idContrat AND
					     		                            cont_table_prix.ID_T_VAL=tv.id AND
			 	       	 									tv.LIBELLE_T_VAL like \"%Valeur%\"");
    		$statement->bindValue('idrub', $idrubLivGMS);
    		$statement->bindValue('idtrajet', $idtrajet);
    
    		$statement->bindValue('idContrat', $idContrat);
    		 
    		$statement->execute();
    		$results = $statement->fetchAll();
    		if(sizeof($results)>=1){
    			$en1=$results[0];
    			$prixLivGMS=$en1['VALEUR'];
    			$tvaLivGMS=($prixLivGMS*$en1['TVA'])/100;
    			$sommeTVA=$sommeTVA+$tvaLivGMS;
    
    		}
    
    		// Calcul Prix Ramassage
    
    		$statement = $connection->prepare("SELECT VALEUR_MIN,VALEUR_MAX,TVA,VALEUR FROM cont_table_prix, type_valeur tv WHERE
					     		                            cont_table_prix.id_rub= :idrub AND
			 	       	 									cont_table_prix.ID_S_TRAJET= :idtrajet AND
															cont_table_prix.etat='Activee' AND
			 	       	 									cont_table_prix.ID_CONTART= :idContrat AND
					     		                            cont_table_prix.ID_T_VAL=tv.id AND
			 	       	 									tv.LIBELLE_T_VAL like \"%valeur%\"");
    		$statement->bindValue('idrub', $idrubRamassage);
    		$statement->bindValue('idtrajet', $idtrajet);
    
    		$statement->bindValue('idContrat', $idContrat);
    		 
    		$statement->execute();
    		$results = $statement->fetchAll();
    		if(sizeof($results)>=1){
    			$en1=$results[0];
    			$prixRamassage=$en1['VALEUR'];
    			$tvaRamassage=($prixRamassage*$en1['TVA'])/100;
    			$sommeTVA=$sommeTVA+$tvaRamassage;
    
    		}
    		 
    		//Calcul Prix Taxe Avis
    
    		$statement = $connection->prepare("SELECT VALEUR_MIN,VALEUR_MAX,TVA,VALEUR FROM cont_table_prix, type_valeur tv WHERE
					     		                            cont_table_prix.id_rub= :idrub AND
			 	       	 									cont_table_prix.ID_S_TRAJET= :idtrajet AND
															cont_table_prix.etat='Activee' AND
			 	       	 									cont_table_prix.ID_CONTART= :idContrat AND
					     		                            cont_table_prix.ID_T_VAL=tv.id AND
			 	       	 									tv.LIBELLE_T_VAL like \"%valeur%\"");
    		$statement->bindValue('idrub', $idrubTaxeAvis);
    
    		$statement->bindValue('idContrat', $idContrat);
    		$statement->bindValue('idtrajet', $idtrajet);
    
    		$statement->execute();
    		$results = $statement->fetchAll();
    		if(sizeof($results)>=1){
    			$en1=$results[0];
    			$prixTaxeAvis=$en1['VALEUR'];
    			$tvaTaxeAvis=($prixTaxeAvis*$en1['TVA'])/100;
    			$sommeTVA=$sommeTVA+$tvaTaxeAvis;
    
    		}
    		 
    		//Calcul Prix Enrigistrement
    		 
    		$statement = $connection->prepare("SELECT VALEUR_MIN,VALEUR_MAX,TVA,VALEUR FROM cont_table_prix, type_valeur tv WHERE
					     		                            cont_table_prix.id_rub= :idrub AND
			 	       	 									cont_table_prix.ID_S_TRAJET= :idtrajet AND
															cont_table_prix.etat='Activee' AND
			 	       	 									cont_table_prix.ID_CONTART= :idContrat AND
					     		                            cont_table_prix.ID_T_VAL=tv.id AND
			 	       	 									tv.LIBELLE_T_VAL like \"%valeur%\"");
    		$statement->bindValue('idrub', $idrubTaxeAvis);
    
    		$statement->bindValue('idContrat', $idContrat);
    		$statement->bindValue('idtrajet', $idtrajet);
    		 
    		$statement->execute();
    		$results = $statement->fetchAll();
    		if(sizeof($results)>=1){
    			$en1=$results[0];
    			$prixEnregistrement=$en1['VALEUR'];
    			$tvaEnregistrement=($prixEnregistrement*$en1['TVA'])/100;
    			$sommeTVA=$sommeTVA+$tvaEnregistrement;
    
    		}
    		 
    
    		$montantHT=$prixTransport+$prixCheque+$prixCrbt+$prixTraite+$prixRetourBL+$prixValorem+$prixLivraison+$prixLivGMS+$prixRamassage+$prixEnregistrement;
    		//Calcul Manutention
    		$statement = $connection->prepare("SELECT VALEUR_MIN,VALEUR_MAX,TVA,VALEUR FROM cont_table_prix, type_valeur tv WHERE
					     		                            cont_table_prix.id_rub= :idrub AND
			 	       	 									cont_table_prix.ID_S_TRAJET= :idtrajet AND
															cont_table_prix.etat='Activee' AND
			 	       	 									cont_table_prix.ID_CONTART= :idContrat AND
					     		                            cont_table_prix.ID_T_VAL=tv.id AND
			 	       	 									tv.LIBELLE_T_VAL like \"%Valeur HT Exped%\"");
    		$statement->bindValue('idrub', $idrubManut);
    		$statement->bindValue('idtrajet', $idtrajet);
    		$statement->bindValue('idContrat', $idContrat);
    		 
    		$statement->execute();
    		$results = $statement->fetchAll();
    		if(sizeof($results)>=1){
    			$en1=$results[0];
    			$val=$en1['VALEUR'];
    			$prixManut=$val*$montantHT;
    			$tvaManut=($prixManut*$en1['TVA'])/100;
    			$sommeTVA=$sommeTVA+$tvaManut;
    
    		}
    		 
    	$montantHT=$montantHT+$prixManut;
    	$montantTTC=$montantHT+$sommeTVA;
    
    	 
    	//prepare the response, e.g.
    	$response = array("rubTransport" => $idRubTransport,
    			"prixTransport" =>  $prixTransport,
    			"rubCheque" =>  $idRubCheque,
    			"prixCheque" =>  $prixCheque,
    			"rubTraite" =>  $idRubTraite,
    			"prixTraite" =>  $prixTraite,
    			"rubCrbt" =>  $idRubCrbt,
    			"prixCrbt" =>  $prixCrbt,
    			"prixVAlorem" =>  $prixValorem,
    			"prixLivraison"=>$prixLivraison,
    			"prixManut" => $prixManut,
    			"prixLivrGMS" => $prixLivGMS,
    			"prixEnrig" =>  $prixEnregistrement,
    			"prixTaxeAvis"=>$prixTaxeAvis,
    			"prixRamassage"=>$prixRamassage,
    			"tvaTransport"=>$tvaTransport,
    			"tvaCheque"=>$tvaCheque,
    			"tvaTraite"=>$tvaTraite,
    			"tvaCrbt"=>$tvaCrbt,
    			"tvaRetourBL"=>$tvaRetourBL,
    			"tvaValorem"=>$tvaValorem,
    			"tvaLivraison"=>$tvaLivraison,
    			"tvaManut"=>$tvaManut,
    			"tvaLivGMS"=>$tvaLivGMS,
    			"tvaRamassage"=>$tvaRamassage,
    			"tvaTaxeAvis"=>$tvaTaxeAvis,
    			"tvaEnrig"=>$tvaEnregistrement,
    			"autreFrais"=>$prixManut+$prixLivGMS,
    			"rubBL" =>  $idrubBL,
    			"prixBL" =>  $prixRetourBL,
    			"retourFond" =>  $prixCheque+$prixCrbt+$prixTraite,
    			"montatHT" =>  $montantHT,
    			"montantTTC"=>$montantTTC,
    			"tva"=>$sommeTVA,
    	);
    	// $response->headers->set('Content-Type', 'application/json');
    
    	// return new Response($resp);
    	//you can return result as JSON
    	return new Response(json_encode($response));
    }
    
    /**
     * Edits an existing Expedition entity.
     * @Secure(roles="ROLE_EDIT_TAXATION")
    
     */
    public function updateTaxationAction() {
    	
    	$params = $this->getRequest()->request->all();
    	
    	
    	$idRubTransport=1;
    	$idRubCheque=8;
    	$idRubTraite=9;
    	$idRubCrbt=10;
    	$idRubFragile=17;
    	$idrubBL=7;
    	$idRubValeur=11;
    	$idRubLivr=2;
    	$idrubManut=12;
    	$idrubLivGMS=6;
    	$idrubRamassage=5;
    	$idrubTaxeAvis=14;
    	$idrubEnregistrement=15;
    	
     	
    	$idExped=$params['idExped'];
    	
    	$idServiceCrbt=$params['idServiceCrbt'];
    	$idServiceVAlorem=$params['idServiceVAlorem'];    	
    	$idServiceManut=$params['idServiceManut'];
    	$idServiceLivrGMS=$params['idServiceLivrGMS'];
    	$idServiceTransport=$params['idServiceTransport'];
    	
    	$idServiceEnrig=$params['idServiceEnrig'];
    	$idServiceCheque=$params['idServiceCheque'];
    	$idServiceTraite=$params['idServiceTraite'];
    	$idServiceBL=$params['idServiceBL'];
    	$idServiceLivraison=$params['idServiceLivraison'];
    	$idServiceTaxeAvis=$params['idServiceTaxeAvis'];
    	$idServiceRamassage=$params['idServiceRamassage'];
    	
    	$prixBL=$params['prixRetourBL'];
    	$prixValAD=$params['prixVAlorem'];
    	$prixEnrig=$params['prixEnrig'];
    	$prixTaxeAvis=$params['prixTaxeAvis'];
    	$prixRamassage=$params['prixRamassage'];
    	$prixTransport=$params['prixTransport'];
    	
    	$prixCrbt=$params['prixCrbt'];	
    	$prixLivrGMS=$params['prixLivrGMS'];
    	$prixManut=$params['prixManut'];
    	$prixLivraison=$params['prixLivraison'];
    	$prixCheque=$params['prixCheque'];
    	$prixTraite=$params['prixTraite'];
    	 
    	
    	$em = $this->getDoctrine()->getEntityManager();
    	$connection = $em->getConnection();
    	 
    	$expedition=$em->getRepository('ComDaufinBundle:Expedition')->find($idExped);
    	$servTransport=$em->getRepository('ComDaufinBundle:SuivService')->find($idServiceTransport);
    	$servCrbt=$em->getRepository('ComDaufinBundle:SuivService')->find($idServiceCrbt);
    	$servValorem=$em->getRepository('ComDaufinBundle:SuivService')->find($idServiceVAlorem);
    	$servLivraison=$em->getRepository('ComDaufinBundle:SuivService')->find($idServiceLivraison);
    	$servEnrig=$em->getRepository('ComDaufinBundle:SuivService')->find($idServiceEnrig);
    	$servLivrGMS=$em->getRepository('ComDaufinBundle:SuivService')->find($idServiceLivrGMS);    	 
    	$servManut=$em->getRepository('ComDaufinBundle:SuivService')->find($idServiceManut);
    	$servTraite=$em->getRepository('ComDaufinBundle:SuivService')->find($idServiceTraite);
    	$servCheque=$em->getRepository('ComDaufinBundle:SuivService')->find($idServiceCheque);
    	$servBL=$em->getRepository('ComDaufinBundle:SuivService')->find($idServiceBL);
    	$servRamassage=$em->getRepository('ComDaufinBundle:SuivService')->find($idServiceRamassage);
    	$servTaxeAvis=$em->getRepository('ComDaufinBundle:SuivService')->find($idServiceTaxeAvis);
    	
    	//Modifier le prix Transport
    	
    	 
   
    	$a=($servTransport->getRub()->getTaxeRubrique()*$prixTransport)/100;
	    $servTransport->setPrixHt($prixTransport);
	    $servTransport->setTva($a);
		$servTransport->setPrixTtc($a+$prixTransport);
    	
    		
    	$a=($servCrbt->getRub()->getTaxeRubrique()*$prixCrbt)/100;   		
		$servCrbt->setPrixHt($prixCrbt);
		$servCrbt->setTva($a);
		$servCrbt->setPrixTtc($prixCrbt+$a);
		
		$a=($servValorem->getRub()->getTaxeRubrique()*$prixValAD)/100;
		$servValorem->setPrixHt($prixValAD);
		$servValorem->setTva($a);
		$servValorem->setPrixTtc($prixValAD+$a);
		
		$a=($servLivrGMS->getRub()->getTaxeRubrique()*$prixLivrGMS)/100;
	    $servLivrGMS->setPrixHt($prixLivrGMS);
	    $servLivrGMS->setTva($a);
	    $servLivrGMS->setPrixTtc($prixLivrGMS+$a);
	   
	    $a=($servManut->getRub()->getTaxeRubrique()*$prixManut)/100;
	    $servManut->setPrixHt($prixManut);
	    $servManut->setTva($a);
	    $servManut->setPrixTtc($prixManut+$a);
	    		   		
	     $a=($servEnrig->getRub()->getTaxeRubrique()*$prixEnrig)/100;
	     $servEnrig->setPrixHt($prixEnrig);
	     $servEnrig->setTva($a);
	     $servEnrig->setPrixTtc($prixEnrig+$a);
	    		 		
	    		 	 
	     $a=($servLivraison->getRub()->getTaxeRubrique()*$prixLivraison)/100;
	     $servLivraison->setPrixHt($prixLivraison);
	     $servLivraison->setTva($a);
	     $servLivraison->setPrixTtc($prixLivraison+$a);
	     
         $a=($servCheque->getRub()->getTaxeRubrique()*$prixCheque)/100;
	     $servCheque->setPrixHt($prixCheque);
	     $servCheque->setTva($a);
	     $servCheque->setPrixTtc($prixCheque+$a);
	    		 	 
	    	 	
	     $a=($servTraite->getRub()->getTaxeRubrique()*$prixTraite)/100;
	     $servTraite->setPrixHt($prixTraite);
	     $servTraite->setTva($a);
	     $servTraite->setPrixTtc($prixTraite+$a);
	     
	     $a=($servBL->getRub()->getTaxeRubrique()*$prixBL)/100;
	     $servBL->setPrixHt($prixBL);
	     $servBL->setTva($a);
	     $servBL->setPrixTtc($prixBL+$a);
	     
	   	     
		 $a=($servRamassage->getRub()->getTaxeRubrique()*$prixRamassage)/100;
		 $servRamassage->setPrixHt($prixRamassage);
		 $servRamassage->setTva($a);
		 $servRamassage->setPrixTtc($prixRamassage+$a);
	    
         $a=($servTaxeAvis->getRub()->getTaxeRubrique()*$prixTaxeAvis)/100;
		 $servTaxeAvis->setPrixHt($prixTaxeAvis);
		 $servTaxeAvis->setTva($a);
		 $servTaxeAvis->setPrixTtc($prixTaxeAvis+$a);
	    		 	  
		 
    	$em->flush();
    	// Update total Montant Expedition
    	//	$expedition=new Expedition();
    	$statement = $connection->prepare("select SUM(prix_ttc) as sommeTTC from suiv_service ss where ss.exept=:idExpedition ");
    	$statement->bindValue('idExpedition', $expedition->getId());
    	$statement->execute();
    	$results = $statement->fetchAll();
    	if(sizeof($results)>=1){
    		$en1=$results[0];
    		$sommeHT=$en1['sommeTTC'];
    		$expedition->setTotalMontant($sommeHT);
    		
    		$operation=new OpererExpedition();
    		$operation->setPersonnel($this->getUser()->getPersonnel());
    		$operation->setDateOperation(new \DateTime());
    		$operation->setTypeOperation("Modification des Prix");
    		$operation->setExept($expedition);    		
    		$em->persist($operation);
    	}else {
    		$error = array("error" => "Modification Impossible, Probléme Montant Total",
    				"codeError"=>12,);
    		return new Response(json_encode($error));
    	}
    	 
	    		 	
	    		 	$em->flush();
	    		 	$response = array("succes" => "Modification Réussie de l'expédition : ".$expedition->getCodeDeclaration(),
	    		 			"codeError"=>90,);
	    		 	return new Response(json_encode($response));
    }
    public function formUpdateTaxationAction(){
    
    
    	$em = $this->getDoctrine()->getManager();
    	$connection = $em->getConnection();
    
    	$statement = $connection->prepare("SELECT ag.* FROM agence ag,affecter af
        		                           where af.personnel=:personnel AND
        		                                 af.agence=ag.id");
    	$statement->bindValue('personnel', $this->getUser()->getPersonnel()->getId());
    	$statement->execute();
    	$ags=$statement->fetchAll();
    	$now=new \DateTime();
    
    
    
    	return $this->render('ComDaufinBundle:Taxation:updateTaxation.html.twig', array(
    			'agence' => $ags[0],
    			'date' =>$now->format("Y-m-d") ,
    	));
    }
    public function getUpdateTaxationAction(){
    	$params = $this->getRequest()->request->all();

    	$codeDeclaration=$params['codeDeclaration'];
    	$em = $this->getDoctrine()->getManager();
    	
    	$entityExped = $em->getRepository('ComDaufinBundle:Expedition')->findOneByCodeDeclaration($codeDeclaration);
    	
    	if (!$entityExped) {
    		$error = array("error" => "Aucune déclaration avec ce code: ".$codeDeclaration,
    				"codeError"=>404,);
    		return new Response(json_encode($error));
    	}
    	$idExped=$entityExped->getId();
    	$entities = $em->getRepository('ComDaufinBundle:Crbt')
    	->createQueryBuilder('c')
    	->join('c.exept', 'e')
    	->where('e.id= '.$idExped)
    	->getQuery()->getArrayResult();
    	
    	if (sizeof($entities) >=1) $entityCrbt=$entities[0];
    	else $entityCrbt=null;
    		
    	$entities = $em->getRepository('ComDaufinBundle:Cheque')
    	->createQueryBuilder('c')
    	->join('c.exept', 'e')
    	->where('e.id= '.$idExped)
    	->getQuery()->getArrayResult();
    		
    	if (sizeof($entities) >=1) $entityCheque=$entities[0];
    	else $entityCheque=null;
    	
    	$entities = $em->getRepository('ComDaufinBundle:Traite')
    	->createQueryBuilder('c')
    	->join('c.exept', 'e')
    	->where('e.id= '.$idExped)
    	->getQuery()->getArrayResult();
    	
    	if (sizeof($entities) >=1) $entityTraite=$entities[0];
    	else $entityTraite=null;
    		
    	
    	$entities = $em->getRepository('ComDaufinBundle:BLivraisonM')
    	->createQueryBuilder('c')
    	->join('c.exept', 'e')
    	->where('e.id= '.$idExped)
    	->getQuery()->getArrayResult();
    	
    	if (sizeof($entities) >=1) $entityBonLivr=$entities[0];
    	else $entityBonLivr=null;
    		
    	//nombre de colis
    	$entities = $em->getRepository('ComDaufinBundle:UniteManu')
    	->createQueryBuilder('c')
    	->join('c.exept', 'e')
    	->where('e.id= '.$idExped)
    	->getQuery()->getArrayResult();
    		
    	if (sizeof($entities) >=1){
    		if($entities[0]['typeUnite']=="Palette"){
    			$nbreTicket=$entityExped->getNbrPalets();
    			 
    		}else{
    			$nbreTicket=$entityExped->getNbrColis();
    		}
    	
    	
    	}
    	else $nbreTicket=0;
    	
    	
    	$deleteForm = $this->createDeleteForm($idExped);
    	
    	$prixTransport=0;
    	$prixCheque=0;
    	$prixTraite=0;
    	$prixCrbt=0;
    	$prixRetourBL=0;
    	$prixValorem=0;
    	$prixLivraison=0;
    	$prixManut=0;
    	$prixLivGMS=0;
    	$prixEnregistrement=0;
    	$prixRamassage=0;
    	$prixTaxeAvis=0;
    	
    	$idServiceTransport;
    	$idServiceRetourBL;
    	$idServiceValorem;
    	$idServiceLivraison;
    	$idServiceManut;
    	$idServiceLivGMS;
    	$idServiceEnregistrement;
    	$idServiceRamassage;
    	$idServiceTaxeAvis;
    	$idServiceCheque;
    	$idServiceTraite;
    	$idServiceCRBT;
    	
    	
    	$tvaTransport=0;
    	$tvaCheque=0;
    	$tvaTraite=0;
    	$tvaCrbt=0;
    	$tvaRetourBL=0;
    	$tvaValorem=0;
    	$tvaLivraison=0;
    	$tvaManut=0;
    	$tvaLivGMS=0;
    	$tvaRamassage=0;
    	$tvaTaxeAvis=0;
    	$tvaEnregistrement=0;
    	$connection = $em->getConnection();
    	
    	$statement = $connection->prepare("SELECT s.id,s.prix_ht,s.tva,s.prix_ttc,s.rub,r.LIBELLE_RUB
				                         FROM suiv_service s, rubrique r
				                          where s.exept=:idExped AND s.rub=r.id
                                           ");
    	$statement->bindValue('idExped',$idExped);
    	$statement->execute();
    	$results = $statement->fetchAll();
    	
    	foreach ($results as $res){
    		if($res['rub']==2){
    			$prixLivraison=$res['prix_ht'];
    			$tvaLivraison=$res['tva'];
    			$idServiceLivraison=$res['id'];
    		}
    		else if($res['rub']==12){
    			$prixManut=$res['prix_ht'];
    			$tvaManut=$res['tva'];
    			$idServiceManut=$res['id'];
    		}
    		else if($res['rub']==6){
    			$prixLivGMS=$res['prix_ht'];
    			$tvaLivGMS=$res['tva'];
    			$idServiceLivGMS=$res['id'];
    		}
    		else if($res['rub']==13){
    			$prixTransport=$res['prix_ht'];
    			$tvaTransport=$res['tva'];
    			$idServiceTransport=$res['id'];
    		}
    		else if($res['rub']==7){
    			$prixRetourBL=$res['prix_ht'];
    			$tvaRetourBL=$res['tva'];
    			$idServiceRetourBL=$res['id'];
    		}
    		else if($res['rub']==11){
    			$prixValorem=$res['prix_ht'];
    			$tvaValorem=$res['tva'];
    			$idServiceValorem=$res['id'];
    		}
    		else if($res['rub']==8){
    			$prixCheque=$res['prix_ht'];
    			$tvaCheque=$res['tva'];
    			$idServiceCheque=$res['id'];
    		}
    		else if($res['rub']==9){
    			$prixTraite=$res['prix_ht'];
    			$tvaTraite=$res['tva'];
    			$idServiceTraite=$res['id'];
    		}
    		else if($res['rub']==10){
    			$prixCrbt=$res['prix_ht'];
    			$tvaCrbt=$res['tva'];
    			$idServiceCRBT=$res['id'];
    		}
    		else if($res['rub']==5){
    			$prixRamassage=$res['prix_ht'];
    			$tvaRamassage=$res['tva'];
    			$idServiceRamassage=$res['id'];
    		}else if($res['rub']==14){
    			$prixTaxeAvis=$res['prix_ht'];
    			$tvaTaxeAvis=$res['tva'];
    			$idServiceTaxeAvis=$res['id'];
    		}else if($res['rub']==15){
    			$prixEnregistrement=$res['prix_ht'];
    			$tvaEnregistrement=$res['tva'];
    			$idServiceEnregistrement=$res['id'];
    		}
    		 
    	
    	
    	}
    	
    	$montantHT=$prixTransport+$prixCheque+$prixCrbt+$prixTraite+$prixRetourBL+$prixValorem+$prixLivraison+$prixLivGMS+$prixRamassage+$prixEnregistrement+$prixManut+$prixTaxeAvis;
    	$sommeTVA=$tvaTransport+$tvaCheque+$tvaCrbt+$tvaTraite+$tvaRetourBL+$tvaValorem+$tvaLivraison+$tvaLivGMS+$tvaRamassage+$tvaEnregistrement+$tvaTaxeAvis+$tvaManut;
    	$montantTTC=$montantHT+$sommeTVA;
    	
    	 
    	
    	
    	$response=array(
    			'idExped'      => $idExped,
    			'entityCrbt'      => $entityCrbt,
    			'entityCheque'      => $entityCheque,
    			'entityTraite'      => $entityTraite,
    			'entityBonLivr'      => $entityBonLivr,
    			'nbreTickets' =>$nbreTicket,
    			"prixCrbt" =>  $prixCrbt,
    			"prixVAlorem" =>  $prixValorem,
    			"prixLivraison"=>$prixLivraison,
    			"prixManut" => $prixManut,
    			"prixLivrGMS" => $prixLivGMS,
    			"prixEnrig" =>  $prixEnregistrement,
    			"prixTaxeAvis"=>$prixTaxeAvis,
    			"prixRamassage"=>$prixRamassage,
    			"prixTransport"=>$prixTransport,
    			"prixTraite"=>$prixTraite,
    			"prixCheque"=>$prixCheque,
    			"prixBL"=>$prixRetourBL,
    			 
    			"idServiceCrbt" =>  $idServiceCRBT,
    			"idServiceVAlorem" =>  $idServiceValorem,
    			"idServiceLivraison"=>$idServiceLivraison,
    			"idServiceManut" => $idServiceManut,
    			"idServiceLivrGMS" => $idServiceLivGMS,
    			"idServiceTransport"=>$idServiceTransport,
    	
    			"idServiceEnrig"=>$idServiceEnregistrement,
    			"idServiceCheque"=>$idServiceCheque,
    			"idServiceTraite"=>$idServiceTraite,
    			"idServiceBL"=>$idServiceRetourBL,
    			"idServiceLivraison"=>$idServiceLivraison,
    			"idServiceTaxeAvis"=> $idServiceTaxeAvis,
    			"idServiceRamassage"=>$idServiceRamassage,
    			 
    	
    			"autreFrais"=>$prixManut+$prixLivGMS,
    			"prixRetourBL" =>  $prixRetourBL,
    			"retourFond" =>  $prixCheque+$prixCrbt+$prixTraite,
    			"montantHT" =>  $montantHT,
    			"montantTTC"=>$montantTTC,
    			"tva"=>$sommeTVA,);
    	return new Response(json_encode($response));
    	
    }
    
//     private function changeStock($exped,$uniteM)
//     {
//     	$em = $this->getDoctrine()->getEntityManager();
//     	$agenceDepart=$exped->getEnvAgence();
//     	//Ajouter Au Stock
//     	$Stock=new Stock();
//     	$Stock->setTypeStock('Agence');
//     	$Stock->setAgence($agenceDepart);
//     	$Stock->setUniteManu($uniteM);
//     	$em->persist($Stock);
    
//     	//Ajouter Mouvement Stock
//     	$MStock=new MouvementStock();
//     	$MStock->setDateMouv(new \DateTime());
//     	$Mouv=$em->getRepository('ComDaufinBundle:Mouvement')->find(1);
//     	$MStock->setAgence($agenceDepart);
//     	$MStock->setUniteManu($uniteM);
//     	$MStock->setMouvement($Mouv);
//     	$MStock->setPersonnel($this->getUser()->getPersonnel());
//     	$em->persist($MStock);
//     }
    
	public function FindAdresseClientAction()
  {
    $params = $this->getRequest()->request->all();
    $name=$params['name'];
    $em = $this->getDoctrine()->getEntityManager();
    $connection = $em->getConnection();

    $statement = $connection->prepare("SELECT ADRESSE_CLT,TEL_CLT from client where TYPE_CLIENT ='Particulier' and NOM_PART=:name");
      $statement->bindValue('name',$name);
      $statement->execute();
      $results = $statement->fetchAll();
      if(sizeof($results)>=1){
      $response=array(
          "adresseC"=>$results[0]['ADRESSE_CLT'],
          "TelC"=>$results[0]['TEL_CLT'],
          );
      return new Response(json_encode($response));
      }else {
        $error = array("message" => "Adresse introuvale !",
            "codeError"=>12,);
        return new Response(json_encode($error));
      }
  }
  
}
