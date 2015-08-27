<?php

namespace Com\DaufinBundle\Controller;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
//use Com\DaufinBundle\Entity\Stock;
use JMS\SecurityExtraBundle\Annotation\Secure;
//use Com\DaufinBundle\Entity\MouvementStock;

class ArrivageController extends Controller {
	
	/**
	 *
	 *  @Secure(roles="ROLE_DECLARER_ARRIVAGE")
	 */
	
	
	public function declarerArrivageAction(){
		
		$em = $this->getDoctrine()->getManager();
		
		$entities = $em->getRepository('ComDaufinBundle:Vehicule')->findAll();
		
		$connection = $em->getConnection();
		
		$statement = $connection->prepare("SELECT ag.* FROM agence ag,affecter af
        		                           where af.personnel=:personnel AND
        		                                 af.agence=ag.id");
		$statement->bindValue('personnel', $this->getUser()->getPersonnel()->getId());
		$statement->execute();
		$ags=$statement->fetchAll();
		
		$now=new \DateTime();
		
	return $this->render('ComDaufinBundle:Arrivage:declarArrivage.html.twig', array(
				'vehicules' => $entities,
				'agence' => $ags[0],
				'date' =>$now->format("Y-m-d") ,
		));
		
	}
	
	public function getVoyagesByVehiculeAction(){
		
		$em = $this->getDoctrine()->getManager();
		$connection = $em->getConnection();
		$params = $this->getRequest()->request->all();
		$idVehicule=$params['vehicule'];

		$statement = $connection->prepare("SELECT vg.id as idVoyage,
				                                  vg.Etat_Voyage as Etat,
				                                  DATE_FORMAT(vg.Date_Planif,'%Y-%m-%d') as DatePlanif,
				                                  vg.Date_Valid as DateValid,
												  t.LIBELLE_TRAJET as LibelleTrajet
				                           FROM vehi_traj_voyg v, voyage vg, trajet t
				                           WHERE                             
				                                  v.VEHICULE=:vehicule and
				                                  v.VOYAGE=vg.id and
				                                  vg.ETAT_VOYAGE='En Route' AND
				                                  v.trajet=t.id");
		
		$statement->bindValue('vehicule',$idVehicule);
		$statement->execute();
		$results = $statement->fetchAll();
		if(sizeof($results)>=1){
		
			return new Response(json_encode($results));
		
		
		}else {
			//$this->parcourExpedition();
			$response = array("code" =>  27,
					"message" =>"Aucune voyage est planifier avec cette vehicule",);
			return new Response(json_encode($response));
		}
	}
	public function getDetailsFromVoyVehiAction(){
	
		$em = $this->getDoctrine()->getManager();
		$connection = $em->getConnection();
		$params = $this->getRequest()->request->all();
		$idVehicule=$params['vehicule'];
		$idVoyage=$params['voyage'];
	
		$statement = $connection->prepare("SELECT vg.id as idVoyage,
				                                  vg.Etat_Voyage as Etat,
				                                  vg.Date_Planif as DatePlanif,
				                                  vg.Date_Valid as DateValid,
												  vh.MATRICULE_VEH as Matricule ,
												  vh.MARQUE_VEH as marque,
												  vh.MODEL_VEH as model,
												  vh.TYPE_VEHICULE as type,
												  vh.POIDS_VIDE as poidsVide,
				                                  vh.POIDS_PLEIN  as poidsPlein
				                           FROM vehi_traj_voyg v, voyage vg,vehicule vh
				                           WHERE  v.voyage=:voyage AND
				                                  v.VEHICULE=:vehicule and
				                                  vg.id=:voyage and
												  vh.id=:vehicule AND
				                                  vg.ETAT_VOYAGE='En Route'");
	
		$statement->bindValue('vehicule',$idVehicule);
		$statement->bindValue('voyage',$idVoyage);
		$statement->execute();
		$results = $statement->fetchAll();
		if(sizeof($results)>=1){
	
			return new Response(json_encode($results));
	
	
		}else {
			//$this->parcourExpedition();
			$response = array("code" =>  27,
					"message" =>"Aucune voyage est planifier avec cette vehicule",);
			return new Response(json_encode($response));
		}
	}
	public function getExpeditionAction(){
		$em = $this->getDoctrine()->getManager();
		$connection = $em->getConnection();
	
		$params = $this->getRequest()->request->all();
			
		$codeDeclaration=$params['codeDeclaration'];
		$idVoyage=$params['voyage'];
		
		$statement = $connection->prepare("SELECT ag.* FROM agence ag,affecter af
        		                           where af.personnel=:personnel AND
        		                                 af.agence=ag.id");
		$statement->bindValue('personnel', $this->getUser()->getPersonnel()->getId());
		$statement->execute();
		
		$ags=$statement->fetchAll();
		$idAgenceREcpetion=$ags[0]['ID'];
	
	
	
	   
		$statement = $connection->prepare("SELECT e.EXP_TRANSP,e.NBR_COLIS,e.NBR_PALETS,e.code_Declaration,e.ETAT_EXP,um.Type_UNITE,ex.S_TRAJET
         									FROM expedition e
											    join exp_transp ex on (e.EXP_TRANSP=ex.ID  or e.exptranstransit=ex.id)
												join exptransp_voyage exv on (exv.EXP_TRANSP=ex.ID AND exv.voyage=:voyage )
												join voyage v on (v.id=:voyage AND v.Etat_Voyage='En Route')
												join unite_manu um on (e.id=um.exept)
         									WHERE e.code_Declaration=:codeDeclaration AND
									         	  e.etat_exp='Voyage' AND
				                                  (e.recAgence=:recAgence or  e.agenceTransit=:recAgence)
		
				                                     ");
		$statement->bindValue('codeDeclaration',$codeDeclaration);
		$statement->bindValue('voyage',$idVoyage);
		$statement->bindValue('recAgence',$idAgenceREcpetion);
		$statement->execute();
		$results = $statement->fetchAll();
	
		if(sizeof($results)>=1){
			$nbreUnite=0;
				
			if( $results[0]['Type_UNITE']=="Colis") $nbreUnite=$results[0]['NBR_COLIS'];
			else $nbreUnite=$results[0]['NBR_PALETS'];
	
			$response = array( "codeDeclaration" =>  $results[0]['code_Declaration'],
					"expedTrans"=> $results[0]['EXP_TRANSP'],
					"typeManu"=> $results[0]['Type_UNITE'],
					"nbreUnite"=>$nbreUnite,
					"sousTrajet"=>$results[0]['S_TRAJET'],
			);
				
			return new Response(json_encode($response));
		}else {
			//$this->parcourExpedition();
			$response = array("codeError" =>  27,
					"message" =>"Erreur de Expedition",);
			return new Response(json_encode($response));
		}
	
	}
	
	/**
	 *
	 *  @Secure(roles="ROLE_DECLARER_ARRIVAGE")
	 */
	
	public function validArrivageAction(){
	
	
		$params = $this->getRequest()->request->all();	
		$em=$this->getDoctrine()->getManager();		
		$tableExemple=$params['tableChargement'];
		$idVoyage=$params['idVoyage'];	
		$arr=$tableExemple;
		$rst=array();
		foreach($arr as $ele)
		{
			$inserer=0;
			foreach($rst as $i=>$candidate)
			{
				$key=null;
				if(isset($candidate['Declaration']) && $candidate['Declaration']==$ele['Declaration'])
				{
					$key=$i;
					$rst[$key]["nbreColis"]+=1;
					$inserer=1;
					break;
				}
			}
	
			if($inserer==0) $rst[]=array_merge(array("Declaration"=>$ele['Declaration'],"typeManu"=>$ele['Unite Manu'],"nbreColis"=>1));
		}
			
		//testant si les expedition entre sont les meme du voyage selectionnee
		// Testant la correspondance entre le nbre Exp entree avec le nbre dans le systeme
		$connection = $em->getConnection();
		
		
		 
		$statement = $connection->prepare("SELECT ag.* FROM agence ag,affecter af
        		                           where af.personnel=:personnel AND
        		                                 af.agence=ag.id");
		$statement->bindValue('personnel', $this->getUser()->getPersonnel()->getId());
		$statement->execute();
		
		$ags=$statement->fetchAll();
		$idAgenceREcpetion=$ags[0]['ID'];
	
		$statement = $connection->prepare("SELECT DISTINCT(e.id),e.NBR_COLIS,e.NBR_PALETS,e.code_Declaration,e.ETAT_EXP,um.TYPE_UNITE
						                           FROM expedition e
												   
												join exp_transp ex on (e.EXP_TRANSP=ex.ID or e.exptranstransit=ex.id )
												join exptransp_voyage exv on (exv.EXP_TRANSP=ex.ID AND exv.voyage=:voyage )
												join voyage v on (v.id=:voyage AND v.Etat_Voyage='En Route')
												join unite_manu um on (e.id=um.exept)
						                           where 
				                                         e.Etat_Exp='Voyage'AND
				                                  (e.recAgence=:recAgence or  e.agenceTransit=:recAgence)
				
                                           ");
		$statement->bindValue('voyage',$idVoyage);
		$statement->bindValue('recAgence',$idAgenceREcpetion);
		$statement->execute();
		$results = $statement->fetchAll();
	
	
	
		$tabError=array();
	
		$noValidate='None';
	
		foreach ($results as $el){
			$j=0;
			$nbreColis=0;
			if($el['TYPE_UNITE']=='Colis') $nbreColis=$el['NBR_COLIS'];
			else $nbreColis=$el['NBR_PALETS'];
	
			foreach ($rst as $r)
			{
				if($r['Declaration']==$el['code_Declaration'])
				{
	
						
					if($nbreColis!=$r['nbreColis']){
						$noValidate='Yes';
						$tabError[]=array_merge($r,array("nbreColisExact"=>$nbreColis,"idExped"=>$el['id'],"SorE"=>"E"));
					}
					else
						$tabError[]=array_merge($r,array("nbreColisExact"=>$nbreColis,"idExped"=>$el['id'],"SorE"=>"S"));
				}
				else $j++;
			}
			if($j>=sizeof($rst)){
				$tabError[]=array_merge(array("Declaration"=>$el['code_Declaration'],"typeManu"=>$el['TYPE_UNITE'],"nbreColis"=>0,"nbreColisExact"=>$nbreColis,"idExped"=>$el['id'],"SorE"=>"E"));
				$noValidate='Yes';}
		}
		 
		if($noValidate=='Yes'){
			//La  Reponse si ya pas de validation entre les expediton entrer==system
			$response = array( "codeError" => 30,
					"message"=>"Vous avez un probleme de declaration",
					"tableExpError"=> $tabError, );
			return new Response(json_encode($response));
		}
		else {
			//Changznt l'etat des expediton
			// On Valide Le voyage
			$perso = $this->getUser()->getPersonnel();
			//On Validant Tous les expedition
			foreach ($tabError as $e){
				$expedition=$em->getRepository('ComDaufinBundle:Expedition')->find($e['idExped']);
				
				//$expedition=new Expedition();
				
				if( 
						($expedition->getTypeTransit()=='Direct') or 
					    ($expedition->getTypeTransit()=='Transit' and $expedition->getExpTransTransit()!=null)
					){
				$expedition->setEtatExp("Arrivage");
				
				$oper=new OpererExpedition();
				//Changer Le 1 en ajoutant la personne connect
					
				$oper->setPersonnel($perso);
				$oper->setExept($expedition);
				$oper->setDateOperation(new \DateTime());
				$oper->setTypeOperation("Arrivage");
				$em->persist($oper);
				
				}
				else if($expedition->getTypeTransit()=='Transit' and $expedition->getExpTransTransit()==null){

					$expedition->setEtatExp("Transition");
					$oper=new OpererExpedition();
					//Changer Le 1 en ajoutant la personne connect
						
					$oper->setPersonnel($perso);
					$oper->setExept($expedition);
					$oper->setDateOperation(new \DateTime());
					$oper->setTypeOperation("Transition");
					$em->persist($oper);
				
				}
				
			//	$this->stockChange($expedition,$type='Arrivage');
	
					}
	
			$voyage=$em->getRepository('ComDaufinBundle:Voyage')->find($idVoyage);
			$voyage->setDateValid(new \DateTime());
			$voyage->setEtatVoyage("Arrivage");
			$operVoyage=new OpererVoyage();
			$operVoyage->setDateOperation(new \DateTime());
			$operVoyage->setTypeOperation("Arrivage");
			$operVoyage->setPersonnel($perso);
			$operVoyage->setVoyage($voyage);
			$em->persist($operVoyage);
			
	
			$em->flush();
			$response = array( "succes" => 40,
					"message"=> "L'arrivage est bien effectuee", );
			return new Response(json_encode($response));
		}
	
	
	}
	
	/**
	 *
	 *  @Secure(roles="ROLE_PLAN_LIVRAISON")
	 */
	
	public function planifierLivraisonAction(){
		

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
	
		return $this->render('ComDaufinBundle:Arrivage:planifLivra.html.twig', array(
				'agence' => $ags[0],
				'secteurs' => $results,
				'nbreExp' =>$nbreExp ,
				'date' =>$now->format("Y-m-d") ,
		));
	}
	
	
	 public function getPlanLivraisonAction(){
	 	$params = $this->getRequest()->request->all();
	 	
	 	$em=$this->getDoctrine()->getManager();	  
	 	$idsecteur=$params['secteur'];
	 	
	 	$connection = $em->getConnection();
 	
		$statement = $connection->prepare("SELECT Distinct(e.code_Declaration) as code,e.poids_Exp as poids,e.nbr_colis as nbreColis,
				                                                         e.recSite,e.rec_Client,e.nbr_Palets as nbrePalettes,um.type_Unite as typeManu
				                           from expedition e,unite_manu um 
				                              where e.recSecteur=:secteur AND
				                                    e.Etat_Exp='Arrivage' AND
				                                    e.id=um.exept ");		
		$statement->bindValue('secteur', $idsecteur);
		$statement->execute();		
		$results=$statement->fetchAll();

		
		if(sizeof($results)>=1){
			$response=array();
			foreach ($results as $res){
				
				$adresse='';
				$tel=' ';
				$contactClient='';	
				
				if($res['recSite']==null){
					$client=$em->getRepository('ComDaufinBundle:Client')->find($res['rec_Client']);
				//	$client=new Client();
					$adresse=$client->getAdresseClt();
					$tel=$client->getTelClt();
					$contactClient=$client->getNomPart().' '.$client->getPrenomPart().' '.$client->getCinPer();
					
				}else{
					$site=$em->getRepository('ComDaufinBundle:Site')->find($res['recSite']);
					//$site=new Site();
					$adresse=$site->getAdresSite();					 
					$contactClient=$site->getLibelleSite();
					
					
				}
				$response[]=array_merge(array("Declaration"=>$res['code'],
						                      "poids"=>$res['poids'],
						                      "nbreColis"=>$res['nbreColis'],
						                      "typeManu"=>$res['typeManu'],
						                      "client"=>$contactClient,
											  "adresse"=>$adresse,
						                      "tel"=>$tel,
										));
				
				
				
			}
			return new Response(json_encode($response));
		}else {
			
			$response = array( "error" => 40,
					"message"=> "Aucune Expedition est envoyé à ce secteur ", );
			return new Response(json_encode($response));
		}
	 }

	 /**
	  *
	  *  @Secure(roles="ROLE_PLAN_LIVRAISON")
	  */
	 
	 
	 public function validPlanifLivrAction(){
	 	$params = $this->getRequest()->request->all();
	 	$em=$this->getDoctrine()->getManager();
	 	$connection = $em->getConnection();
	 	$table=$params['table'];
	 	$idSecteur=$params['secteur'];
	 	$secteur=$em->getRepository("ComDaufinBundle:Secteur")->find($idSecteur);
	 	$personne=$this->getUser()->getPersonnel();
	 	//$secteur=new Secteur();
	 	$now=new \DateTime();
	 	$statement = $connection->prepare("SELECT ag.* FROM agence ag,affecter af
        		                           where af.personnel=:personnel AND
        		                                 af.agence=ag.id");
	 	$statement->bindValue('personnel', $personne->getId());
	 	$statement->execute();
	 	$ags=$statement->fetchAll();
	 	
	 	$name="Planification-Livraison-".$secteur->getCodeSecteur()."-".$now->format('y-m-d');
	 	$html2pdf = new \Html2Pdf_Html2Pdf('P','A4', 'fr', true, 'UTF-8', array(1, 2, 1, 1));
	 	$html2pdf->pdf->SetDisplayMode('real');
	 	
	 
	 	$content='<page backtop="2mm" backbottom="2mm" backleft="2mm" backright="2mm" style="font-size:6pt;bordercolor:#000000;">';
	 	$content.=' <page_header>
				       <table class="page_header" style="width:100%;height:80px;border:none">
				           <tr> <td  rowspan="2"  style="">
                                <img alt="gLOG" style=" margin-left: 5px;margin-top: 2px; width:150px;"  src="./bundles/comdaufin/images/ticket.png" />
                               </td>
				                <td style=" margin-left: 15px;margin-top: 2px; width:150px;">   </td>
								<td style=" margin-left: 5px;margin-top: 2px; width:150px;">  </td>
								<td style=" margin-left: 5px;margin-top: 2px; width:150px;">Date  </td>
								<td style=" margin-left: 5px;margin-top: 2px; width:150px;"> '.$now->format('Y-m-d').'  </td>
           					</tr>
							 <tr>
				                <td style=" margin-left: 15px;margin-top: 2px; width:150px;"> Code Agence  </td>
								<td style=" margin-left: 5px;margin-top: 2px; width:150px;"> '.$ags[0]['CODE_AGENCE'].' </td>
								<td style=" margin-left: 5px;margin-top: 2px; width:150px;">Libellée Agence   </td>
								<td style=" margin-left: 5px;margin-top: 2px; width:150px;"> '.$ags[0]['LIBELLE_AG'].' </td>
           					</tr>
        			</table>
				 </page_header>';
	 	$content .='<div style="margin-top:100px; " ><br/><p style="text-align:center;font-size:20px"><b>Planification de Livraison</b> </p>';
	 	$content.='<table align="center" style=" width:100%; " >';
	 	$content.='<tr style="font-size:13px; width:400px; text-align:center;  font-weight:bold">
		  				         
							    <td>Ville</td>
				
		  				        <td > Secteur</td>
		  				        
		  				   </tr>';
	 	$content.='<tr style="height: 120px; text-align:left; font-size:12px;">
		  						 
							    <td  style=" padding:10px;"> Code Ville : '.$secteur->getVille()->getCodeVille().' <br/> Libellee Ville : '.$secteur->getVille()->getLibelleVille().' </td>	 	
		  				        <td  style=" padding:10px; "> Code Secteur : '.$secteur->getCodeSecteur().' <br/> LibellÃ©e Secteur : '.$secteur->getLibelleSecteur().'</td>
		  				      </tr>';
	 		
	 	$content.='</table>';
	 	$content.='<table align="center" style=" width:100%;">';
	 	$content.='<tr style=" text-align:center;  font-size:12px;    background-color: #DDDDFF;" >
			
			  						<td style=" margin-left: 5px;margin-top: 2px; width:40px;">Declaration</td>
					                <td style=" margin-left: 5px;margin-top: 2px; width:30px;">Poids</td>
	 								<td style=" margin-left: 5px;margin-top: 2px; width:30px;">Type</td>
					                <td style=" margin-left: 5px;margin-top: 2px; width:40px;">Nbre.Colis</td>
							        <td style=" margin-left: 5px;margin-top: 2px; width:120px;">Client Destinataire</td>
					                <td style=" margin-left: 5px;margin-top: 2px; width:120px;">Adresse Destinataire</td>	 			
					                <td style=" margin-left: 5px;margin-top: 2px; width:80px;">TÃ©l Destinataire</td>	 			                    
					                <td style=" margin-left: 5px;margin-top: 2px; width:120px;"></td>
		 
	 	
		            	 			 </tr>';
	 		
	 	
	 	foreach ($table as $value) {
	 		
	 		$expedition=$em->getRepository("ComDaufinBundle:Expedition")->findOneByCodeDeclaration($value['Declaration']);
	 		$expedition->setEtatExp("PlanifLivraison");
	 		
	 		$operExp=new OpererExpedition();
	 		$operExp->setDateOperation(new \DateTime());
	 		$operExp->setTypeOperation("PlanifLivraison");
	 		$operExp->setExept($expedition);
	 		$operExp->setPersonnel($personne);
	 		$em->persist($operExp);
	 		$content.='<tr style="font-size:11px;border-bottom: 1px solid #000; ">
				  						<td style="text-align:center;   ">'.$value['Declaration'].'</td>
						                <td style=" text-align:center;  ">'.$value['Poids'].'</td>
						                <td style="text-align:center;   ">'.$value['Type'].'</td>
						                <td style=" text-align:center;  ">'.$value['Nbre Colis'].'</td>
						                <td style="text-align:center;  ">'.$value['Client Destainataire'].'</td>
						                <td style="text-align:center;  ">'.$value['Adresse Destinataire'].'</td>
						                <td style=" text-align:center;  ">'.$value['Tel Destinataire'].'</td>
						                <td style="text-align:center;  "></td>
				            	  </tr>';
	 	}
	 	$content.='</table></div></page>';
	 		
	 	$html2pdf->writeHTML($content);
	 	$html2pdf->Output('TicketTaxation/'.$name.'.pdf', 'F');
	 	
	 	$em->flush();
	 	
	 	$response = array("urlPDF" => "http://daufin.g-logmaroc.com/web/TicketTaxation/".$name.".pdf",
	 			"statut" => "1",);
	 	return new Response(json_encode($response));
	 	 
	 	
	 	
	 	
	 }

	 /**
	  *
	  *  @Secure(roles="ROLE_DECLARER_LIVRAISON")
	  */
	 
	 
	 public function declarLivraisonAction(){
	 
	 
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
	 
	 	return $this->render('ComDaufinBundle:Arrivage:declarLivraison.html.twig', array(
	 			'agence' => $ags[0],
	 			'secteurs' => $results,
	 			'nbreExp' =>$nbreExp ,
	 			'date' =>$now->format("Y-m-d") ,
	 	));
	 }
	 public function getExpeditionLivraisonAction(){
	 	
	 	$em = $this->getDoctrine()->getManager();
	 	$connection = $em->getConnection();
	 
	 	$params = $this->getRequest()->request->all();
	 		
	 	$codeDeclaration=$params['codeDeclaration'];
	 
	 	$statement = $connection->prepare("SELECT ag.* FROM agence ag,affecter af
        		                           where af.personnel=:personnel AND
        		                                 af.agence=ag.id");
	 	$statement->bindValue('personnel', $this->getUser()->getPersonnel()->getId());
	 	$statement->execute();
	 
	 	$ags=$statement->fetchAll();
	 	$idAgenceREcpetion=$ags[0]['ID'];

	 	$statement = $connection->prepare("SELECT e.EXP_TRANSP,e.NBR_COLIS,e.NBR_PALETS,e.code_Declaration,e.ETAT_EXP,um.Type_UNITE
         									FROM expedition e, unite_manu um         										
                                             WHERE e.code_Declaration=:codeDeclaration AND
									         	   e.etat_exp='PlanifLivraison' AND
									               e.id=um.exept AND
												   e.recAgence=:recAgence ");
	 	$statement->bindValue('codeDeclaration',$codeDeclaration);
	 	$statement->bindValue('recAgence',$idAgenceREcpetion);
	 	$statement->execute();
	 	$results = $statement->fetchAll();
	 
	 	if(sizeof($results)>=1){
	 		$nbreUnite=0;
	 
	 		if( $results[0]['Type_UNITE']=="Colis") $nbreUnite=$results[0]['NBR_COLIS'];
	 		else $nbreUnite=$results[0]['NBR_PALETS'];
	 
	 		$response = array( "codeDeclaration" =>  $results[0]['code_Declaration'],
	 				"expedTrans"=> $results[0]['EXP_TRANSP'],
	 				"typeManu"=> $results[0]['Type_UNITE'],
	 				"nbreUnite"=>$nbreUnite,
	 		);
	 
	 		return new Response(json_encode($response));
	 	}else {
	 		
	 		$response = array("codeError" =>  27,
	 				"message" =>"Erreur de Expedition",);
	 		return new Response(json_encode($response));
	 	}
	 
	 }

	 /**
	  *
	  *  @Secure(roles="ROLE_DECLARER_LIVRAISON")
	  */
	 
	 
	 public function validLivraisonAction(){
	 	 
	 	$em = $this->getDoctrine()->getManager();
	 	$connection = $em->getConnection();	 
	 	$params = $this->getRequest()->request->all();	 
	 	$codeDeclaration=$params['codeDeclaration'];	 
	 	$statement = $connection->prepare("SELECT ag.* FROM agence ag,affecter af
        		                           where af.personnel=:personnel AND
        		                                 af.agence=ag.id");
	 	$statement->bindValue('personnel', $this->getUser()->getPersonnel()->getId());
	 	$statement->execute();	 
	 	$ags=$statement->fetchAll();
	 	$idAgenceREcpetion=$ags[0]['ID'];	 	
	 	$exp=$em->getRepository("ComDaufinBundle:Expedition")->findOneByCodeDeclaration($codeDeclaration);	 	
	 	if($exp==null){
	 		$response = array("codeError" =>  404,
	 				"message" =>"Expedition Introuvable",);
	 		return new Response(json_encode($response));
	 	}
	 	else {	 	 	 
	 		if($exp->getRecAgence()->getId()==$idAgenceREcpetion && $exp->getEtatExp()=='PlanifLivraison'){
	 			$exp->setEtatExp("Livraison");
	 			$exp->setRecDate(new \DateTime());
	 			$operExped=new OpererExpedition();
	 			$operExped->setDateOperation(new \DateTime());
	 			$operExped->setExept($exp);
	 			$operExped->setPersonnel($this->getUser()->getPersonnel());
	 			$operExped->setTypeOperation("Livraison");
	 			$em->persist($operExped);
	 			$em->flush();
	 		//	$this->stockChange($exp,$type='Livraison');
	 			$response = array("succes" =>  200,
	 					"message" =>"Livraison est Bien effectuÃ©",);
	 			return new Response(json_encode($response));
	 			
	 		}else {
	 			$response = array("codeError" =>  404,
	 					"message" =>" Erreur de Expedition",);
	 			return new Response(json_encode($response));	 			
	 		}
	 		
	 	}
	
	 
	 
	 
	 }
	 
// 	 private function stockChange($exped,$type)
// 	 {
// 	 	if ($type=='Arrivage')
// 	 	{
// 	 		$em = $this->getDoctrine()->getManager();
// 	 		$connection = $em->getConnection();
// 	 		$statement = $connection->prepare("SELECT s.`ID`
//                                                FROM `stock` s, `unite_manu` um
//                                                WHERE s.`UNITE_MANU`=um.`ID` and um.`EXEPT`=:EXEPT " );
// 	 		$statement->bindValue('EXEPT',$exped->getId());
// 	 		$statement->execute();
// 	 		$results = $statement->fetchAll();
// 	 		// changer l'etat de stock de transite en Agence_Distinataire de l'Agence de dÃ©part
// 	 		foreach($results as $result )
// 	 		{
// 	 			$stock=$em->getRepository('ComDaufinBundle:Stock')->find($result);
// 	 			$stock->setTypeStock('Agence_Distinataire');
// 	 		}
	 
// 	 		// Ajouter les unites Manutentions au stock de l'agence d'arrivage
// 	 		$uniteManus=$em->getRepository('ComDaufinBundle:UniteManu')->find($exped->getId());
	 
// 	 		foreach($uniteManus as $uniteManu )
// 	 		{
// 	 			//Ajouter Mouvement Stock Agence de depart
// 	 			$MStock=new MouvementStock();
// 	 			$MStock->setDateMouv(new \DateTime());
// 	 			$Mouv=$em->getRepository('ComDaufinBundle:Mouvement')->find(2);
// 	 			$MStock->setAgence($exped->getEnvAgence());
// 	 			$MStock->setUniteManu($uniteManu);
// 	 			$MStock->setMouvement($Mouv);
// 	 			$MStock->setPersonnel($this->getUser()->getPersonnel());
// 	 			$em->persist($MStock);
	 
// 	 			//Ajouter Stock Agence d'arrivee
// 	 			$Stock=new Stock();
// 	 			$Stock->setTypeStock('Agence');
// 	 			$Stock->setAgence($exped->getRecAgence());
// 	 			$Stock->setUniteManu($uniteManu);
// 	 			$em->persist($Stock);
	 
// 	 			//Ajouter Mouvement Stock Agence d'arrivee
// 	 			$MStock2=new MouvementStock();
// 	 			$MStock2->setDateMouv(new \DateTime());
// 	 			$Mouv2=$em->getRepository('ComDaufinBundle:Mouvement')->find(1);
// 	 			$MStock2->setAgence($exped->getRecAgence());
// 	 			$MStock2->setUniteManu($uniteManu);
// 	 			$MStock2->setMouvement($Mouv2);
// 	 			$MStock2->setPersonnel($this->getUser()->getPersonnel());
// 	 			$em->persist($MStock2);
// 	 		}
// 	 	}
// 	 	if ($type=='Livraison')
// 	 	{
// 	 		$em = $this->getDoctrine()->getManager();
// 	 		$connection = $em->getConnection();
// 	 		$statement = $connection->prepare("SELECT s.`ID`
//                                                FROM `stock` s, `unite_manu` um
//                                                WHERE s.`UNITE_MANU`=um.`ID` and um.`EXEPT`=:EXEPT and `AGENCE`=:AGENCE" );
// 	 		$statement->bindValue('EXEPT',$exped->getId());
// 	 		$statement->bindValue('AGENCE',$exped->getRecAgence());
// 	 		$statement->execute();
// 	 		$results = $statement->fetchAll();
// 	 		// changer l'etat de stock de transite en Agence_Distinataire de l'Agence de dÃ©part
// 	 		foreach($results as $result )
// 	 		{
// 	 			$stock=$em->getRepository('ComDaufinBundle:Stock')->find($result);
// 	 			$stock->setTypeStock('Livree');
// 	 		}
	 
// 	 		// Finaliser les mouvements
// 	 		$uniteManus=$em->getRepository('ComDaufinBundle:UniteManu')->find($exped->getId());
	 
// 	 		foreach($uniteManus as $uniteManu )
// 	 		{
	 
// 	 			//Ajouter Mouvement Stock Agence d'arrivee
// 	 			$MStock=new MouvementStock();
// 	 			$MStock->setDateMouv(new \DateTime());
// 	 			$Mouv=$em->getRepository('ComDaufinBundle:Mouvement')->find(2);
// 	 			$MStock->setAgence($exped->getRecAgence());
// 	 			$MStock->setUniteManu($uniteManu);
// 	 			$MStock->setMouvement($Mouv);
// 	 			$MStock->setPersonnel($this->getUser()->getPersonnel());
// 	 			$em->persist($MStock);
// 	 		}
	 
// 	 	}
	 
// 	 }
	 
	 
	 
}