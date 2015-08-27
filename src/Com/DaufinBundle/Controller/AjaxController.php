<?php

namespace Com\DaufinBundle\Controller;

use Com\DaufinBundle\Entity\Ville;

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
use Com\DaufinBundle\Entity\VehiTrajVoyg;
use Com\DaufinBundle\Entity\Trajet;
use JMS\SecurityExtraBundle\Annotation\Secure;
//use Com\DaufinBundle\Entity\Stock;

//use Com\DaufinBundle\Entity\MouvementStock;


class AjaxController extends Controller{
 
	
	/**
     * 
     *  @Secure(roles="ROLE_ADD_TAXATION")
     */
	public function calculMontantAction(){
		
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
	     
	       $typeContrat=$params['typeContrat'];
	       
	       if($typeContrat=="compte"){  
	       	
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
	 	       	 	$error = array("error" => "Le Client ne despose d'aucune contrat Active.",
	 	       	 			"codeError"=>14,);
	 	       	 	return new Response(json_encode($error));
	 	       	 }
			 	       	 
			 	       	 $statement = $connection->prepare("SELECT VALEUR_MIN,VALEUR_MAX,TVA,VALEUR FROM cont_table_prix, type_valeur tv WHERE
			     		                            cont_table_prix.id_rub= :idrub AND 
			 	       	 							cont_table_prix.ID_S_TRAJET= :idtrajet AND
			     									cont_table_prix.etat='Activee' AND
													cont_table_prix.ID_CONTART= :idContrat AND
			     		                            cont_table_prix.ID_T_VAL=tv.id AND tv.MIN_Min<= :poids AND
			     		                            tv.MAX_Type>=:poids AND tv.LIBELLE_T_VAL like \"%poid%\"");
			 	       	 $statement->bindValue('idrub', $idRubTransport);
			 	       	 $statement->bindValue('idContrat', $idContrat);
			 	       	 $statement->bindValue('idtrajet', $idtrajet);
			 	       	 $statement->bindValue('poids', $poids);
			 	       	 $statement->execute();
			 	       	 $results = $statement->fetchAll();
			 	       	 if(sizeof($results)>=1){
			 	       	 	$en1=$results[0];
			 	       	 	$prixTransport=$en1['VALEUR'];
			 	       	 	$tvaTransport=($en1['TVA']*$prixTransport)/100;
			 	       	 	$sommeTVA=$sommeTVA+$tvaTransport;
			 	       	 	//$prixTTCTransport=$prixHTTransport+$tvaTransport;
			 	       	 		
			 	       	 		
			 	       	 }
			 	       	  
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
	       	
	       			
	       	
	       }else {
	     
					     //Calcul Prix Transport
					     $statement = $connection->prepare("SELECT VALEUR_MIN,VALEUR_MAX,TVA,VALEUR FROM table_prix, type_valeur tv WHERE
					     		                            table_prix.rub= :idrub AND table_prix.s_trajet= :idtrajet AND
					     									table_prix.etat='Activee' AND
					     		                            table_prix.ID_T_VAL=tv.id AND tv.MIN_Min<= :poids AND
					     		                            tv.MAX_Type>=:poids AND tv.LIBELLE_T_VAL like \"%poid%\"");
					     $statement->bindValue('idrub', $idRubTransport);
					     $statement->bindValue('idtrajet', $idtrajet);
					     $statement->bindValue('poids', $poids);
					     $statement->execute();
					     $results = $statement->fetchAll();
					     if(sizeof($results)>=1){ 
											    	$en1=$results[0];
											     	$prixTransport=$en1['VALEUR'];
											     	$tvaTransport=($en1['TVA']*$prixTransport)/100;
											     	$sommeTVA=$sommeTVA+$tvaTransport;
											     	//$prixTTCTransport=$prixHTTransport+$tvaTransport;
											     	
											     	
					        }else {
					        	
					        	$error = array("error" => "Le Poid est Hors tranche",
					        			"codeError"=>12,);
					        	return new Response(json_encode($error));
					        }
					                      
				                       
					           //Montant Cheque 
					    if(!empty($cheque)){
					                         
					     $statement = $connection->prepare("SELECT VALEUR_MIN,VALEUR_MAX,TVA,VALEUR FROM table_prix, type_valeur tv WHERE
					     		                            table_prix.rub= :idrub AND table_prix.s_trajet= :idtrajet AND
					     		table_prix.etat='Activee' AND
					     		                            table_prix.ID_T_VAL=tv.id AND tv.LIBELLE_T_VAL like \"%cheque%\"");
					     $statement->bindValue('idrub', $idRubCheque);
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
						     $statement = $connection->prepare("SELECT VALEUR_MIN,VALEUR_MAX,TVA,VALEUR FROM table_prix, type_valeur tv WHERE
						     		                            table_prix.rub= :idrub AND
						     									table_prix.s_trajet= :idtrajet AND
						     									table_prix.etat='Activee' AND
						     		                            table_prix.ID_T_VAL=tv.id AND
						     									tv.LIBELLE_T_VAL like \"%Crbt%\"");
						     $statement->bindValue('idrub', $idRubCrbt);
						     $statement->bindValue('idtrajet', $idtrajet);
						      
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
							     $statement = $connection->prepare("SELECT VALEUR_MIN,VALEUR_MAX,TVA,VALEUR FROM table_prix, type_valeur tv WHERE
							     		                            table_prix.rub= :idrub AND 
							     									table_prix.s_trajet= :idtrajet AND
							     									table_prix.etat='Activee' AND
							     		                            table_prix.ID_T_VAL=tv.id AND
							     									tv.LIBELLE_T_VAL like \"%traite%\"");
							     $statement->bindValue('idrub', $idRubTraite);
							     $statement->bindValue('idtrajet', $idtrajet);
							      
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
						          $statement = $connection->prepare("SELECT VALEUR_MIN,VALEUR_MAX,TVA,VALEUR FROM table_prix, type_valeur tv WHERE
						     		                            table_prix.rub= :idrub AND table_prix.s_trajet= :idtrajet AND
						          		table_prix.etat='Activee' AND
						     		                            table_prix.ID_T_VAL=tv.id AND tv.LIBELLE_T_VAL like \"%Retour BL%\"");
						          $statement->bindValue('idrub', $idrubBL);
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
					       	$statement = $connection->prepare("SELECT VALEUR_MIN,VALEUR_MAX,TVA,VALEUR FROM table_prix, type_valeur tv WHERE
							     		                            table_prix.rub= :idrub AND table_prix.s_trajet= :idtrajet AND
					       			table_prix.etat='Activee' AND
							     		                            table_prix.ID_T_VAL=tv.id AND tv.LIBELLE_T_VAL like \"%valeur%\"");
					       	$statement->bindValue('idrub', $idRubValeur);
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
					       
					       	$statement = $connection->prepare("SELECT VALEUR_MIN,VALEUR_MAX,TVA,VALEUR FROM table_prix, type_valeur tv WHERE
							     		                            table_prix.rub= :idrub AND table_prix.s_trajet= :idtrajet AND
					       			table_prix.etat='Activee' AND
							     		                            table_prix.ID_T_VAL=tv.id AND tv.LIBELLE_T_VAL like \"%domicile%\"");
					       	$statement->bindValue('idrub', $idRubLivr);
					       	$statement->bindValue('idtrajet', $idtrajet);
					       	
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
					       $statement = $connection->prepare("SELECT VALEUR_MIN,VALEUR_MAX,TVA,VALEUR FROM table_prix, type_valeur tv WHERE
							     		                            table_prix.rub= :idrub AND table_prix.s_trajet= :idtrajet AND
					       		table_prix.etat='Activee' AND
							     		                            table_prix.ID_T_VAL=tv.id AND tv.LIBELLE_T_VAL like \"%Valeur%\"");
					       $statement->bindValue('idrub', $idrubLivGMS);
					       $statement->bindValue('idtrajet', $idtrajet);
					        
					       $statement->execute();
					       $results = $statement->fetchAll();
					       if(sizeof($results)>=1){
					       	$en1=$results[0];
					       	$prixLivGMS=$en1['VALEUR'];	     
					       	$tvaLivGMS=($prixLivGMS*$en1['TVA'])/100;  	 
					       	$sommeTVA=$sommeTVA+$tvaLivGMS;
					       
					       }
					       
					       // Calcul Prix Ramassage
					       
					       $statement = $connection->prepare("SELECT VALEUR_MIN,VALEUR_MAX,TVA,VALEUR FROM table_prix, type_valeur tv WHERE
							     		                            table_prix.rub= :idrub AND table_prix.s_trajet= :idtrajet AND
					       		table_prix.etat='Activee' AND
							     		                            table_prix.ID_T_VAL=tv.id AND tv.LIBELLE_T_VAL like \"%valeur%\"");
					       $statement->bindValue('idrub', $idrubRamassage);
					       $statement->bindValue('idtrajet', $idtrajet);
					        
					       $statement->execute();
					       $results = $statement->fetchAll();
					     	  if(sizeof($results)>=1){
							       	$en1=$results[0];
							       	$prixRamassage=$en1['VALEUR'];
							       	$tvaRamassage=($prixRamassage*$en1['TVA'])/100;
							       	$sommeTVA=$sommeTVA+$tvaRamassage;
					       
					      			 }
					      			 
					      	//Calcul Prix Taxe Avis
					      	
					      			 $statement = $connection->prepare("SELECT VALEUR_MIN,VALEUR_MAX,TVA,VALEUR FROM table_prix, type_valeur tv WHERE
							     		                            table_prix.rub= :idrub AND table_prix.s_trajet= :idtrajet AND
					      			 		table_prix.etat='Activee' AND
							     		                            table_prix.ID_T_VAL=tv.id AND tv.LIBELLE_T_VAL like \"%valeur%\"");
					      			 $statement->bindValue('idrub', $idrubTaxeAvis);
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
					      			 
					      			 $statement = $connection->prepare("SELECT VALEUR_MIN,VALEUR_MAX,TVA,VALEUR FROM table_prix, type_valeur tv WHERE
							     		                            table_prix.rub= :idrub AND table_prix.s_trajet= :idtrajet AND
					      			 		table_prix.etat='Activee' AND
							     		                            table_prix.ID_T_VAL=tv.id AND tv.LIBELLE_T_VAL like \"%valeur%\"");
					      			 $statement->bindValue('idrub', $idrubEnregistrement);
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
					       $statement = $connection->prepare("SELECT VALEUR_MIN,VALEUR_MAX,TVA,VALEUR FROM table_prix, type_valeur tv WHERE
							     		                            table_prix.rub= :idrub AND table_prix.s_trajet= :idtrajet AND
					       		table_prix.etat='Activee' AND
							     		                            table_prix.ID_T_VAL=tv.id AND tv.LIBELLE_T_VAL like \"%Valeur HT Exped%\"");
					       $statement->bindValue('idrub', $idrubManut);
					       $statement->bindValue('idtrajet', $idtrajet);
					        
					       $statement->execute();
					       $results = $statement->fetchAll();
					       if(sizeof($results)>=1){
					       	$en1=$results[0];
					        $val=$en1['VALEUR'];	       	 	       	
					       	$prixManut=$val*$montantHT;
					       	$tvaManut=($prixManut*$en1['TVA'])/100;
					       	$sommeTVA=$sommeTVA+$tvaManut;
					       	 
					       }
	          
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
	public function chargerSiteAction(){
		
		$params = $this->getRequest()->request->all();
		$idClient=$params['idClient'];

		$em = $this->getDoctrine()->getManager();
		$entities = $em->getRepository('ComDaufinBundle:Site')
					->createQueryBuilder('s')
					->join('s.client', 'c')
					->where('c.id= '.$idClient)
					->getQuery()
					->getArrayResult();

		return new Response(json_encode($entities));
		
	}
	
	/**
	 *
	 *  @Secure(roles="ROLE_ADD_TAXATION")
	 */
	
	public function save2PdfTaxationAction(){

	
		$params = $this->getRequest()->request->all();
		$em = $this->getDoctrine()->getManager();
		
		$idExped=$params['idExped'];
	//	$idExped=1;
		
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
		
		$connection = $em->getConnection();		
		$statement = $connection->prepare("SELECT ag.* FROM agence ag,affecter af
        		                           where af.personnel=:personnel AND
        		                                 af.agence=ag.id");
		$statement->bindValue('personnel', $this->getUser()->getPersonnel()->getId());
		$statement->execute();
		$ags=$statement->fetchAll();
		
		$now=new \DateTime();
		//recupere Les prix
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
		
		$statement = $connection->prepare("SELECT s.prix_ht,s.tva,s.prix_ttc,s.rub,r.LIBELLE_RUB 
				                         FROM suiv_service s, rubrique r 
				                          where s.exept=:idExped AND s.rub=r.id 
                                           ");
		$statement->bindValue('idExped',$entityExped->getId());		
		$statement->execute();
		$results = $statement->fetchAll();
		
		foreach ($results as $res){
			if($res['rub']==2){
				$prixLivraison=$res['prix_ht'];
				$tvaLivraison=$res['tva'];
			  }
			 else if($res['rub']==12){
				$prixManut=$res['prix_ht'];
				$tvaManut=$res['tva'];
			  } 
			  else if($res['rub']==6){
			  	$prixLivGMS=$res['prix_ht'];
			  	$tvaLivGMS=$res['tva'];
			  }
			  else if($res['rub']==13){
			  	$prixTransport=$res['prix_ht'];
			  	$tvaTransport=$res['tva'];
			  }
			  else if($res['rub']==7){
			  	$prixRetourBL=$res['prix_ht'];
			  	$tvaRetourBL=$res['tva'];
			  }
			  else if($res['rub']==11){
			  	$prixValorem=$res['prix_ht'];
			  	$tvaValorem=$res['tva'];
			  } 
			  else if($res['rub']==8){
			  	$prixCheque=$res['prix_ht'];
			  	$tvaCheque=$res['tva'];
			  }
			  else if($res['rub']==9){
			  	$prixTraite=$res['prix_ht'];
			  	$tvaTraite=$res['tva'];
			  } 
			  else if($res['rub']==10){
			  	$prixCrbt=$res['prix_ht'];
			  	$tvaCrbt=$res['tva'];
			  }
        	else if($res['rub']==5){
        		$prixRamassage=$res['prix_ht'];
        		$tvaRamassage=$res['tva'];
        		 
        	}else if($res['rub']==14){
        		$prixTaxeAvis=$res['prix_ht'];
        		$tvaTaxeAvis=$res['tva'];
        		 
        	}else if($res['rub']==15){
        		$prixEnregistrement=$res['prix_ht'];
        		$tvaEnregistrement=$res['tva'];
        		  
        	}
        	
			  
			
		}
		
		$montantHT=$prixTransport+$prixCheque+$prixCrbt+$prixTraite+$prixRetourBL+$prixValorem+$prixLivraison+$prixLivGMS+$prixRamassage+$prixEnregistrement+$prixManut+$prixTaxeAvis;
        $sommeTVA=$tvaTransport+$tvaCheque+$tvaCrbt+$tvaTraite+$tvaRetourBL+$tvaValorem+$tvaLivraison+$tvaLivGMS+$tvaRamassage+$tvaEnregistrement+$tvaTaxeAvis+$tvaManut;
        $montantTTC=$montantHT+$sommeTVA;
		
		
		$name='Facture-'.$entityExped->getCodeDeclaration().'-'.$now->format('dmY h:m:s');
		
		$html = $this->renderView('ComDaufinBundle:Default:taxationToPdf.html.twig', array(
										            'entityExped'      => $entityExped,
													'entityCrbt'      => $entityCrbt,
													'agence'      => $ags[0],
													'date'      => $now->format('d/m/Y'),
													'entityCheque'      => $entityCheque,
													'entityTraite'      => $entityTraite,
													'entityBonLivr'      => $entityBonLivr,
													"prixCrbt" =>  $prixCrbt,
													"prixVAlorem" =>  $prixValorem,
													"prixLivraison"=>$prixLivraison,
													"prixManut" => $prixManut,
													"prixLivrGMS" => $prixLivGMS,
													"prixEnrig" =>  $prixEnregistrement,
													"prixTaxeAvis"=>$prixTaxeAvis,
													"prixRamassage"=>$prixRamassage,
													"prixTransport"=>$prixTransport,
													"autreFrais"=>$prixManut+$prixLivGMS,													 
													"prixBL" =>  $prixRetourBL,
													"retourFond" =>  $prixCheque+$prixCrbt+$prixTraite,
													"montatHT" =>  $montantHT,
													"montantTTC"=>$montantTTC,
													"tva"=>$sommeTVA,

		));
		
		$html2pdf = new \Html2Pdf_Html2Pdf('P',array(200,145), 'fr', true, 'UTF-8', array(1, 2, 1, 1));
		$html2pdf->pdf->SetDisplayMode('real');
		$html2pdf->writeHTML($html);
		$html2pdf->Output('FacturesTaxation/'.$name.'.pdf', 'F');
		//$html2pdf->
		//return $html2pdf;
		
	
		
    	$response = array("urlPDF" => "http://daufin.g-logmaroc.com/web/FacturesTaxation/".$name.".pdf",
 							"statut" => "1",);
		
		return new Response(json_encode($response));
		
	}
	
	public function getSiteAction(){
		
		$params = $this->getRequest()->request->all();
		$em = $this->getDoctrine()->getManager();
		$connection = $em->getConnection();
		
		$idSite=$params['idSite'];
		$idClient=$params['idClient'];
		
		
		//Tel Client 
		$client=$em->getRepository('ComDaufinBundle:Client')->find($idClient);

		$statement = $connection->prepare("SELECT id, etat_contart FROM contrat c where 
										     c.client= :idClient AND
										     c.etat_contart=\"Activee\" ");
		
		$statement->bindValue('idClient', $idClient);		
		$statement->execute();
		$results = $statement->fetchAll();
		$numContrat;
		// num Contart actif
		if(sizeof($results)>=1){
			$en1=$results[0];
			$numContrat=$en1['id'];
		}
		
		
		$Site = $em->getRepository('ComDaufinBundle:Site')->find($idSite);
		
		
		$response = array("idSite" =>  $Site->getId(),
					      "adresseSite" => $Site->getAdresSite(),	
						  "tel" => $client->getTelClt(),
				          "client" => $client->__toString(),
				          "numContrat" => $numContrat,
							);
		 
			 
		// $response->headers->set('Content-Type', 'application/json');
		
		// return new Response($resp);
		//you can return result as JSON
		return new Response(json_encode($response));
		
		
	}
	/**
	 *
	 *  @Secure(roles="ROLE_ADD_TAXATION")
	 */
	
	public function imprimeTicketAction(){ 
	
 		$params = $this->getRequest()->request->all();
 		$idExpedition=$params['idExped'];
		 	//	$idExpedition=13;
		
 		$em = $this->getDoctrine()->getManager();
 		$expedition = $em->getRepository('ComDaufinBundle:Expedition')->find($idExpedition);
 		
 		$connection = $em->getConnection();
 		
 		$adresseExped=$expedition->getEnvClient()->getAdresseClt();
 		$telExped=$expedition->getEnvClient()->getTelClt();
 		$adresseDest=$expedition->getRecClient()->getAdresseClt();
 		$telDest=$expedition->getRecClient()->getTelClt();
 		$nomExped=$expedition->getEnvClient()->getNomPart().' '.$expedition->getEnvClient()->getPrenomPart();
 		$nomDest=$expedition->getRecClient()->getNomPart().' '.$expedition->getRecClient()->getPrenomPart();
 		
 		if($expedition->getEnvClient()->getTypeClient()=="Compte"){
 			
 			//por Expediteur
 			$statement = $connection->prepare("SELECT ADRES_SITE,LIBELLE_SITE FROM site s WHERE
	     		                           s.id=:idSite ");
 			$statement->bindValue('idSite', $expedition->getEnvSite()->getId());
 			$statement->execute();
 			$results = $statement->fetchAll();			
 			if(sizeof($results)>=1){
 				$en1=$results[0];
 				if($en1['ADRES_SITE']!='')
 					$adresseExped=$en1['ADRES_SITE'];
 				//if($en1['LIBELLE_SITE']!='')
 					//$nomExped=$en1['LIBELLE_SITE'];
 					$nomExped= $expedition->getEnvClient()->getRSociale();
 			}
 			
 			
 		}
 		
 		if($expedition->getRecClient()->getTypeClient()=="Compte"){
 			//por Destinataire
 			$statement = $connection->prepare("SELECT ADRES_SITE,LIBELLE_SITE FROM site s WHERE
	     		                           s.id=:idSite ");
 			$statement->bindValue('idSite', $expedition->getRecSite()->getId());
 			$statement->execute();
 			$results = $statement->fetchAll();
 			if(sizeof($results)>=1){
 				$en1=$results[0];
 				if($en1['ADRES_SITE']!='')
 					$adresseDest=$en1['ADRES_SITE'];
 				//if($en1['LIBELLE_SITE']!='')
 					//$nomDest=$en1['LIBELLE_SITE'];
 					$nomDest=$expedition->getRecClient()->getRSociale();
 			}
 			
 			
 		}
 		
 		
 		
 		$statement = $connection->prepare("SELECT TYPE_UNITE FROM unite_manu um WHERE
	     		                           um.exept=:idExped ");
 		$statement->bindValue('idExped', $idExpedition);
 		$statement->execute();
 		$results = $statement->fetchAll();
 		
 		$name="Ticket-".$expedition->getCodeDeclaration();
 		
 		if(sizeof($results)>=1){
 			$en1=$results[0];
 			$typeManu=$en1['TYPE_UNITE'];
 			$nbreUnite=0;
 			if($typeManu=="Colis")
 				$nbreUnite=$expedition->getNbrColis();
 			else
 				$nbreUnite=$expedition->getNbrPalets();

 			$html2pdf = new \Html2Pdf_Html2Pdf('P',array(74,74), 'fr', true, 'UTF-8', array(1, 2, 1, 1));
 			$html2pdf->pdf->SetDisplayMode('real');
			 				
			 			for ($i = 1; $i <= $nbreUnite; $i++){			 					 		
				 			$html = $this->renderView('ComDaufinBundle:Default:ticketTaxation.html.twig', array(
				 					'entityExped'      => $expedition,
				 					'unite'      => $i,
				 					'nbreUnite'      => $nbreUnite,
				 					'adresseExped'      =>$adresseExped,
				 					'telExped'      =>$telExped,
				 					'adresseDest'      =>$adresseDest,
				 					'telDest'      =>$telDest,
				 					'nomExped'      =>$nomExped,
				 					'nomDest'      =>$nomDest,
				 			)); 			
 							$html2pdf->writeHTML($html);
			 			}
 			$html2pdf->Output('TicketTaxation/'.$name.'.pdf', 'F'); 			 			
		 		} 		
		 				     
 		$response = array("urlPDF" => "http://daufin.g-logmaroc.com/web/TicketTaxation/".$name.".pdf",
 							"statut" => "1",);
 			
 		
 		// $response->headers->set('Content-Type', 'application/json');
 		
 		// return new Response($resp);
 		//you can return result as JSON
 		return new Response(json_encode($response));

	}
	
	public function chargerSecteurAction(){
	
		$params = $this->getRequest()->request->all();
		$idVille=$params['idVille'];
	
		$em = $this->getDoctrine()->getManager();
		$entities = $em->getRepository('ComDaufinBundle:Secteur')
		->createQueryBuilder('s')
		->join('s.ville', 'v')
		->where('v.id= '.$idVille)
		->getQuery()
		->getArrayResult();
	
		return new Response(json_encode($entities));
	
	}
	/**
	 *
	 *  @Secure(roles="ROLE_ADD_TAXATION")
	 */
	
	public function testCodeDeclarationAction(){
		
		$em = $this->getDoctrine()->getManager();
		$connection = $em->getConnection();
		 
		$params = $this->getRequest()->request->all();
			$code=$params['code'];
								
			$statement = $connection->prepare("SELECT id FROM expedition e WHERE
	     		                              e.code_Declaration=:code ");
			$statement->bindValue('code',$code);
			$statement->execute();
			$results = $statement->fetchAll();
			
			if(sizeof($results)>=1){
				
				$response = array("code" =>  16,
					      "message" =>"Le Code ".$code." est deja enrigistre",							
							);	
			}
			else {$response = array("code" =>  17,
					      "message" =>"Le Code ".$code." est Accepte",							
							);	
			}
		
		
			return new Response(json_encode($response));
		
	}
	
	/**
	 *
	 *  @Secure(roles="ROLE_PROPOSER_CHARGEMENT")
	 */
	
	
	public function propChargementAction(){
	
		$em = $this->getDoctrine()->getManager();
		$connection = $em->getConnection();
		$params = $this->getRequest()->request->all();
		$idVehicule=$params['idVehicule'];
		$idTrajet=$params['idTrajet'];
	    $idVoyage=$params['idVoyage'];
		$date=$params['date'];
		

		//$idVehicule=1;
		//$idTrajet=1;
		//$idVoyage=1;
		
		$statement = $connection->prepare("SELECT vg.id 
											FROM vehi_traj_voyg v, voyage vg 
											WHERE v.TRAJET=:idTrajet 
											and v.VEHICULE=:idVehicule 
											and v.VOYAGE=:idVoyage 
											and vg.ID=v.VOYAGE 
											and vg.ETAT_VOYAGE='Validation' AND
											MONTH(v.DATE_PASSER)=MONTH(:date) AND
		 									DAY(v.DATE_PASSER)=DAY(:date) AND
		 									YEAR(v.DATE_PASSER)= YEAR(:date) ");
		$statement->bindValue('idVehicule',$idVehicule);
		$statement->bindValue('idTrajet',$idTrajet);
		$statement->bindValue('idVoyage',$idVoyage);
		$statement->bindValue('date',$date);
		$statement->execute();
		$results = $statement->fetchAll();

		
		
		if(sizeof($results)>=1){
	//		e.ETAT_EXP='Declarer' AND
			$statement = $connection->prepare("select DISTINCT(e.id),ex.ID, ex.S_TRAJET, e.CODE_DECLARATION as codeExp, e.NBR_COLIS, e.NBR_PALETS, e.POIDS_EXP,st.CODE_SOUS_TRAJET as codeSTrajet
					                           from expedition e 
					                                join exp_transp ex on (e.EXP_TRANSP=ex.ID or e.exptranstransit=ex.id)
					                                join exptransp_voyage exv on (exv.EXP_TRANSP=ex.ID)
					                                join sous_trajet st on (ex.S_TRAJET=st.ID) 
					                           where exv.VOYAGE=:idVoyage ");
			$statement->bindValue('idVoyage',$idVoyage);
			$statement->execute();
			$results = $statement->fetchAll();
				
				if(sizeof($results)>=1){
				
				return new Response(json_encode($results));
			
				}else {
					//$this->parcourExpedition();
					$response = array("code" =>  25,
							          "message" =>"Aucune Expedition et Prete, veulliez verifier La relation avec l'expedition du transport",);
					return new Response(json_encode($response));
					}
			}
		else {
			$response = array("code" =>  23,
 			"message" =>"Cette combinaison ne figure pas sur les voyages valides",					
			);
			return new Response(json_encode($response));
		}
		
}

	public function parcourExpeditionAction(){
	
	try{
		$em = $this->getDoctrine()->getManager();
		$connection = $em->getConnection();
		
		$ETs=$em->getRepository("ComDaufinBundle:ExpTransp")->findAll();
		$Es=$em->getRepository("ComDaufinBundle:Expedition")->findAll();
		// operationnel;
		$p = $this->getUser()->getPersonnel();
		
		$statement = $connection->prepare("SELECT ag.* FROM agence ag,affecter af
        		                           where af.personnel=:personnel AND
        		                                 af.agence=ag.id");
		$statement->bindValue('personnel', $this->getUser()->getPersonnel()->getId());
		$statement->execute();
		$ags=$statement->fetchAll();
		$idAgence=$ags[0][id];
		
		//$E=new Expedition();
		//$ET=new ExpTransp();
		
		foreach ($Es as $E)
			if($E->getExpTransp()==null)
				foreach ($ETs as $ET)
					if($ET->getsTrajet()->getVilleDepart()->getId()==$E->getEnvVille()->getId() &&
					   $ET->getsTrajet()->getVilleArrivee()->getId()==$E->getRecVille()->getId() &&
					   $E->getEnvAgence()->getId()==$idAgence && // Agence Actuel 
					   $E->getDateDecl()>= $ET->getDateCreation())
				{
					$E->setExpTransp($ET);
					$E->setEtatExp("Planification");
					$ET->setNbreExpedition($ET->getNbreExpedition()+1);
					
					//tracabiliter au Opere Expedition
					$operation=new OpererExpedition();
					$operation->setPersonnel($p);
					$operation->setDateOperation(new \DateTime());
					$operation->setTypeOperation("Planification");
					$operation->setExept($E);
					$em->persist($operation);
					$em->flush();
				}
					
					
		}catch(Exception $e){
			
			$response = array("code" =>  23,
					"message" =>$e->getMessage(),
			);
			//echo $e;
			return new Response(json_encode($response));
		}

			$response = array("code" =>  25,
					"message" =>"succes de generation",);
			 
			return new Response(json_encode($response));
			
	}
	
	/**
	 *
	 *  @Secure(roles="ROLE_PROPOSER_CHARGEMENT")
	 */
	
	public function generCahrg2PDFAction(){
	
		$params = $this->getRequest()->request->all();
		$idVoyage=$params['voyage'];
		$idVehicule=$params['vehicule'];
		$idTrajet=$params['trajet'];
		//$idVoyage=1;
		//$idVehicule=1;
		//$idTrajet=1;
	
		
		$em = $this->getDoctrine()->getManager();			
		$connection = $em->getConnection();
		$voyage = $em->getRepository('ComDaufinBundle:Voyage')->find($idVoyage);
		$vehicule = $em->getRepository('ComDaufinBundle:Vehicule')->find($idVehicule);
		$trajet = $em->getRepository('ComDaufinBundle:Trajet')->find($idTrajet);
		
			$statement = $connection->prepare("select DISTINCT(e.id) as idExped,ex.ID, ex.S_TRAJET, e.CODE_DECLARATION as codeExp, e.NBR_COLIS, e.NBR_PALETS, e.POIDS_EXP,um.id,um.type_Unite 
					                           from expedition e join exp_transp ex on (e.EXP_TRANSP=ex.ID or e.exptranstransit=ex.id)
					                                join exptransp_voyage exv on (exv.EXP_TRANSP=ex.ID)
					                                join sous_trajet st on (ex.S_TRAJET=st.ID) 
					                                join unite_manu um on (e.id=um.exept)
					                          where e.ETAT_EXP='Planification' AND
					                                exv.VOYAGE=:idVoyage ");
			$statement->bindValue('idVoyage',$idVoyage);
			$statement->execute();
			$results = $statement->fetchAll();
		
			if(sizeof($results)>=1){
			}else {
				//$this->parcourExpedition();
				$response = array("codeError" =>  25,
						"error" =>"Aucune Expedition et Prete, veulliez verifier La relation avec l'expedition du transport",);
				return new Response(json_encode($response));
			}
		$name="Chargement".$idTrajet."-".$idVehicule."-".$idVoyage;
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
								<td style=" margin-left: 5px;margin-top: 2px; width:150px;">  </td>
								<td style=" margin-left: 5px;margin-top: 2px; width:150px;">   </td>
           					</tr>
							 <tr> 
				                <td style=" margin-left: 15px;margin-top: 2px; width:150px;">  </td>
								<td style=" margin-left: 5px;margin-top: 2px; width:150px;">  </td>
								<td style=" margin-left: 5px;margin-top: 2px; width:150px;">  </td>
								<td style=" margin-left: 5px;margin-top: 2px; width:150px;"> </td>
           					</tr>
        			</table>
				 </page_header>';
	//	$content.=' <page_footer>
				       
	//			 </page_footer>';
  		$content .='<div style="margin-top:100px;" ><br/><p style="text-align:center;font-size:20px"><b>Liste Proposition du Chargement des Expeditions</b> </p>';
  		$content.='<table align="center" style=" width:100%; " >';
  		$content.='<tr style="font-size:13px; text-align:center;  font-weight:bold"> 
  				        <td></td>
  				        <td > Trajet</td>
  				        <td > Voyage</td>
  				        <td > Vehicule</td>
  				   </tr>';
  		$content.='<tr style="height: 120px; text-align:left; font-size:12px;">
  						<td></td>
  				        <td style=" padding:10px;"> Code Trajet : '.$trajet->getCodeTrajet().' <br/> Libellee Trajet : '.$trajet->getLibelleTrajet().' </td>
  				        <td style=" padding:10px; "> Voyage : '.$voyage->getId().' <br/> Date de Validation : '.$voyage->getDatePlanif()->format('Y-m-d').'</td>
  				        <td style=" padding:10px; "> Matricule : '.$vehicule->getMatriculeVeh().' <br/> Poids Vehicule : '.$vehicule->getPoidsPlein().'</td>
  				   </tr>';
  		
  		$content.='</table>';
  		$content.='<table align="center" style=" width:100%;">';
  		$i=0;
  		$numExp=$results[0]['idExped'];
  		$nbreManu=0;
  		$idST=$results[0]['S_TRAJET'];
  		$idET=$results[0]['ID'];
  		$poidsTotal=$results[0]['POIDS_EXP'];
  		$nbreColis=$results[0]['NBR_COLIS'];
  		$ST = $em->getRepository('ComDaufinBundle:SousTrajet')->find($idST);
  		//$ST=new SousTrajet();
  		$content.='<tr style=" text-align:left;  font-size:13px; font-weight:bold;  background-color: #da2820;" >
								<td  colspan="2" style=" margin-left: 5px;margin-top: 2px; width:70px;">Sous Trajet</td>
		  				        <td   colspan="2" style=" margin-left: 5px;margin-top: 2px; width:70px;">'.$ST->getId().' - '.$ST->getCodeSousTrajet().'</td>		  						 
				                <td colspan="2" style=" margin-left: 5px;margin-top: 2px; width:70px;">Expd Transport</td>
				                <td   colspan="2"  style=" margin-left: 5px;margin-top: 2px; width:70px;">'.$idET.'</td>
				               
		  				        
		            	  	</tr>';
  		$content.='<tr style=" text-align:center;  font-size:12px;   background-color: #DDDDFF;" >
						
	  						<td style=" margin-left: 5px;margin-top: 2px; width:70px;">Code</td>
			                <td style=" margin-left: 5px;margin-top: 2px; width:70px;">Type Manut</td>
			                <td style=" margin-left: 5px;margin-top: 2px; width:70px;">Nbre.Colis</td>
			                <td style=" margin-left: 5px;margin-top: 2px; width:70px;">Poids Total</td>
	  				        <td style=" margin-left: 5px;margin-top: 2px; width:70px;">Num.Colis</td>
	  				        <td  colspan="3" style=" margin-left: 5px;margin-top: 2px; width:120px;">Remarque</td>
		 
            	 			 </tr>';
  		
  		foreach ($results as $res){
  			
  			if($idST!=$res['S_TRAJET'] || $idET!=$res['ID'] ){
  				$ST = $em->getRepository('ComDaufinBundle:SousTrajet')->find($res['S_TRAJET']);
  				
  				$content.='<tr style=" text-align:left;  font-size:13px; font-weight:bold;  background-color: #da2820;" >
								<td colspan="2" style=" margin-left: 5px;margin-top: 2px; width:70px;">Sous Trajet</td>
		  				        <td colspan="2"  style=" margin-left: 5px;margin-top: 2px; width:70px;">'.$ST->getId().' - '.$ST->getCodeSousTrajet().'</td>
		  						<td colspan="2" style=" margin-left: 5px;margin-top: 2px; width:70px;">Expd Transport </td>
				                <td colspan="2"  style=" margin-left: 5px;margin-top: 2px; width:70px;">'.$res['ID'].'</td>
				                 
		            	  	</tr>';
  				$content.='<tr style=" text-align:center;  font-size:12px;   background-color: #DDDDFF;" >
							
	  						<td style=" margin-left: 5px;margin-top: 2px; width:70px;">Code</td>
			                <td style=" margin-left: 5px;margin-top: 2px; width:70px;">Type Manut</td>
			                <td style=" margin-left: 5px;margin-top: 2px; width:70px;">Nbre.Colis</td>
			                <td style=" margin-left: 5px;margin-top: 2px; width:70px;">Poids Total</td>
	  				        <td style=" margin-left: 5px;margin-top: 2px; width:70px;">Num.Colis</td>
	  				        <td colspan="3" style=" margin-left: 5px;margin-top: 2px; width:120px;">Remarque</td>
  						 
		   
            	 			 </tr>';
  			
  				$idST=$res['S_TRAJET'] ;
  				$idET=$res['ID'];
  			}
  			else {
  			
		  			if($numExp==$res['idExped']) $i++;
		  			    else {$i=1; $numExp=$res['idExped']; $poidsTotal+=$res['POIDS_EXP']; $nbreColis+=$res['NBR_COLIS'];}
		  			
		  			if($res['type_Unite']=="Colis") $nbreManu=$res['NBR_COLIS'];
		  				else $nbreManu=$res['NBR_PALETS'];
		  				
		  			$content.='<tr style="font-size:12px;border-bottom: 1px solid #000; ">		  					    	                
		  						<td style="text-align:center;   ">'.$res['codeExp'].'</td>		                 
				                <td style=" text-align:center;  ">'.$res['type_Unite'].'</td>		       
				                <td style="text-align:center;   ">'.$res['NBR_COLIS'].'</td>		                
				                <td style="text-align:center;  ">'.$res['POIDS_EXP'].'</td>		                		
		  				        <td style=" text-align:center;  ">'.$i.'/'.$nbreManu.'</td>
		  				        <td style=" text-align:center;  "></td>
		  				        <td style=" text-align:center; "> </td>
				                <td style=" text-align:center; "> </td>			               
		            	  </tr>';
  				}
  		}
  		$content.='<tr style=" text-align:right;  font-size:13px; font-weight:bold;  background-color: #da2820; ">
  				                <td ></td>
				                <td  style=" text-align:right; "> Nombre TOTAL</td>
				                <td  style="text-align:right;">'.$nbreColis.'</td>		  
		  					    <td  style=" text-align:right; "> Poids TOTAL</td>
				                <td colspan="2" style="text-align:right;">'.$poidsTotal.'</td>		                 
				                <td colspan="2" "></td>            
				                              
		            	  </tr>';
  		$content.='</table></div></page>';
			
		$html2pdf->writeHTML($content);
			
		$html2pdf->Output('TicketTaxation/'.$name.'.pdf', 'F');
		
	
		$response = array("urlPDF" => "http://daufin.g-logmaroc.com/web/TicketTaxation/".$name.".pdf",
				"statut" => "1",);
	
			
		// $response->headers->set('Content-Type', 'application/json');
			
		// return new Response($resp);
		//you can return result as JSON
		return new Response(json_encode($response));
	
	}
	
	public function detailByVehiculeAction(){
		
		$params = $this->getRequest()->request->all();
		 
		$matrVehicule=$params['vehicule'];
		//$matrVehicule='69369-A-56';
		
		
		$em = $this->getDoctrine()->getManager();
		$connection = $em->getConnection();
		
		$statement = $connection->prepare("select 
				v.MATRICULE_VEH,v.MARQUE_VEH,v.MODEL_VEH,v.TYPE_VEHICULE,v.POIDS_VIDE,v.POIDS_PLEIN ,
				t.ID,t.CODE_TRAJET,t.LIBELLE_TRAJET ,
				vy.ID,vy.DATE_PLANIF,vy.DATE_VALID 
				from vehicule v, trajet t, voyage vy, vehi_traj_voyg vtv 
				where v.Matricule_VEH=:matricule AND 
				v.id=vtv.vehicule AND
				vtv.voyage=vy.id AND 
				vy.ETAT_VOYAGE='Validation' AND
				vtv.trajet=t.id ");
		$statement->bindValue('matricule',$matrVehicule);
		$statement->execute();
		$results = $statement->fetchAll();
		
		if(sizeof($results)>=1){
			
			return new Response(json_encode($results));
		}else {
			//$this->parcourExpedition();
			$response = array("codeError" =>  26,
					"message" =>"La vehicule selectionner, n'est associee a aucune voyage planifier",);
			return new Response(json_encode($response));
		}
		
		
		
	}
	
	public function getExpeditionAction(){
		

		$params = $this->getRequest()->request->all();
			
		$codeDeclaration=$params['codeDeclaration'];
		//$codeDeclaration='CAFE000003';
		$idVoyage=$params['voyage'];
		
		
		$em = $this->getDoctrine()->getManager();
		$connection = $em->getConnection();
		
		$statement = $connection->prepare("SELECT e.EXP_TRANSP,e.NBR_COLIS,e.NBR_PALETS,e.code_Declaration,e.ETAT_EXP,um.Type_UNITE,ex.S_TRAJET 				              
         									FROM expedition e
											  join exp_transp ex on (e.EXP_TRANSP=ex.ID or e.exptranstransit=ex.id)
											  join exptransp_voyage exv on (exv.EXP_TRANSP=ex.ID and exv.voyage=:voyage )
											  join unite_manu um on (e.id=um.exept)
											  join voyage v on (v.id=:voyage and v.Etat_Voyage='Validation')
											
         										WHERE e.code_Declaration=:codeDeclaration AND
									         	       e.etat_exp='Planification'  ");
		$statement->bindValue('codeDeclaration',$codeDeclaration);
		$statement->bindValue('voyage',$idVoyage);
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
	 *  @Secure(roles="ROLE_VALIDER_CHARGEMENT")
	 */
	
	public function validChargementAction(){
	
	
		$params = $this->getRequest()->request->all();
		
		$em=$this->getDoctrine()->getManager();
			
		
		$tableExemple=$params['tableChargement'];
		$idVoyage=$params['idVoyage'];
// 		$idVoyage=1;
// 		$tableExemple='[
// 		                {"Sous Trajet":"11","Exp Transp":"8","Declaration":"19308","Nombre Colis":"2","Num Colis":"001","typeManu":"Palette"},
// 		                {"Sous Trajet":"11","Exp Transp":"8","Declaration":"19302","Nombre Colis":"2","Num Colis":"002","typeManu":"Colis"},
// 		                {"Sous Trajet":"11","Exp Transp":"8","Declaration":"19302","Nombre Colis":"2","Num Colis":"003","typeManu":"Colis"},
// 				        {"Sous Trajet":"11","Exp Transp":"8","Declaration":"19303","Nombre Colis":"2","Num Colis":"001","typeManu":"Colis"},
// 		                {"Sous Trajet":"11","Exp Transp":"8","Declaration":"19303","Nombre Colis":"2","Num Colis":"001","typeManu":"Colis"},
// 		                {"Sous Trajet":"11","Exp Transp":"8","Declaration":"19305","Nombre Colis":"2","Num Colis":"001","typeManu":"Colis"},	               
// 		                {"Sous Trajet":"11","Exp Transp":"8","Declaration":"19305","Nombre Colis":"2","Num Colis":"002","typeManu":"Colis"}	                  
// 				]';
		
		
		
		//$arr=json_decode($tableExemple,true);

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
					 
					if($inserer==0) $rst[]=array_merge(array("Declaration"=>$ele['Declaration'],"typeManu"=>$ele['Unitee Manu'],"nbreColis"=>1));
				}
			
				// Testant si les expedition entre sont les meme du voyage selectionnee
				// Testant la correspondance entre le nbre Exp entree avec le nbre dans le systeme
				$connection = $em->getConnection();
				
// 				$statement1 = $connection->prepare("SELECT ag.* FROM agence ag,affecter af
//         		                           where af.personnel=:personnel AND
//         		                                 af.agence=ag.id");
// 				$statement1->bindValue('personnel', $this->getUser()->getPersonnel()->getId());
// 				$statement1->execute();
// 				$ags=$statement1->fetchAll();
// 				$envAgence=$ags[0]['ID'];
				 
				
				$statement = $connection->prepare("SELECT DISTINCT(e.id),e.NBR_COLIS,e.NBR_PALETS,e.code_Declaration,e.ETAT_EXP,um.TYPE_UNITE
						                                FROM expedition e
								
														     join exp_transp ex on (e.EXP_TRANSP=ex.ID or e.exptranstransit=ex.id)
															 join exptransp_voyage exv on (exv.EXP_TRANSP=ex.ID and exv.voyage=:voyage )
															 join unite_manu um on (e.id=um.exept)
															 join voyage v on (v.id=:voyage and v.Etat_Voyage='Validation')
						             		              where  
							                                 e.etat_exp='Planification'  
                                           ");
				$statement->bindValue('voyage',$idVoyage);
			//	$statement->bindValue('idAgence',$envAgence);
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
		   	 		$expedition->setEtatExp("Voyage");
		   	 		
		   	 		$oper=new OpererExpedition();
		   	 		//Changer Le 1 en ajoutant la personne connect
		   	 		
		   	 		$oper->setPersonnel($perso);
		   	 		$oper->setExept($expedition);
		   	 		$oper->setDateOperation(new \DateTime());
		   	 		$oper->setTypeOperation("Voyage");
		   	 		$em->persist($oper);
		   	 	//	$this->stockChange($expedition);

		   	 			}
		   	 	
		   	 	$voyage=$em->getRepository('ComDaufinBundle:Voyage')->find($idVoyage);
		   	 	$voyage->setDateValid(new \DateTime());
		   	 	$voyage->setEtatVoyage("Validation");
		   	 	$operVoyage=new OpererVoyage();
		   	 	$operVoyage->setDateOperation(new \DateTime());
		   	 	$operVoyage->setTypeOperation("Validation");
		   	 	$operVoyage->setPersonnel($perso);
		   	 	$operVoyage->setVoyage($voyage);
		   	 	$em->persist($operVoyage);
		   	 	
		   	 	$em->flush();
		   	 	$response = array( "succes" => 40,
		   	 			"message"=> "Le chargement est validee,le voyage aussi", );
		   	 	return new Response(json_encode($response));
		   	 }
		
	
	}
	public function chargerVehiculeVoyageAction(){
		
		$em = $this->getDoctrine()->getManager();
		$connection = $em->getConnection();
		$params = $this->getRequest()->request->all();
		//$idVehicule=$params['idVehicule'];
		$idTrajet=$params['trajet'];
		//$idVoyage=$params['idVoyage'];
		//$date=$params['date'];

		
		$statement = $connection->prepare("SELECT vg.id as idVoyage,vg.DATE_PLANIF as datePlanif,vh.id as idVehicule,vh.MATRICULE_VEH as matricule,vh.MARQUE_VEH as marque ,vh.MODEL_VEH as model,vh.TYPE_VEHICULE as type
				                           FROM vehi_traj_voyg v, voyage vg,vehicule vh
				                           WHERE v.TRAJET=:idTrajet and 
				                                 v.VEHICULE=vh.id and
				                                 v.VOYAGE=vg.id and
				                                 vg.ETAT_VOYAGE='Validation' ");
	 
		$statement->bindValue('idTrajet',$idTrajet);
		$statement->execute();
		$results = $statement->fetchAll();
		if(sizeof($results)>=1){
			 
			return new Response(json_encode($results));
		
			 
		}else {
				//$this->parcourExpedition();
				$response = array("code" =>  27,
						"message" =>"Aucune voyage est planifier a ce Trajet",);
				return new Response(json_encode($response));
			}
		 
	}
	
	public function voyageChargAction()
	{
		$em = $this->getDoctrine()->getManager();
		$connection = $em->getConnection();
		$params = $this->getRequest()->request->all();
		$idTrajet=$params['idTrajet'];
		$statement = $connection->prepare("SELECT v.ID, v.DATE_PLANIF
                                                    FROM `vehi_traj_voyg` vtv, `voyage` v
                                                    WHERE v.ID=vtv.VOYAGE and vtv.TRAJET=:idTrajet and (v.ETAT_VOYAGE='Planification' OR v.ETAT_VOYAGE='Validation')" );
		$statement->bindValue('idTrajet',$idTrajet);
		$statement->execute();
		$results = $statement->fetchAll();
	
		if(sizeof($results)>=1){
			return new Response(json_encode($results));
	
		}
		else {
			$response = array("code" =>  23,
					"message" =>"Aucun elements",
			);
			return new Response(json_encode($response));
		}
	}
	
	public function expTanspChargAction()
	{
		$em = $this->getDoctrine()->getManager();
		$connection = $em->getConnection();
		$params = $this->getRequest()->request->all();
		$idVoyage=$params['idVoyage'];
		//$vDateAffect=$params['vDateAffect'];
		$typeSelect=$params['frm'];
		if ($typeSelect=='ExpTrspVg')
		{
			$statement = $connection->prepare("SELECT ex.*, v1.LIBELLE_VILLE as VILLE_Depart, v2.LIBELLE_VILLE as VILLE_Arrivee, st.CODE_SOUS_TRAJET
                                                    FROM vehi_traj_voyg v, exp_transp ex, trajet_s_trajet tst, sous_trajet st
                                                    INNER JOIN ville as v1 on st.VILLE_Depart = v1.ID
                                                    INNER JOIN ville as v2 on st.VILLE_Arrivee = v2.ID
                                                    WHERE   v.TRAJET=tst.TRAJET
                                                    AND st.ID=tst.SOUS_TRAJET
                                                        AND ex.S_TRAJET=tst.SOUS_TRAJET
                                                        AND ex.ID not in (SELECT exp_transp from exptransp_voyage where VOYAGE=:idVoyage)
                                                        AND v.VOYAGE=:idVoyage" );
			$statement->bindValue('idVoyage',$idVoyage);
			$statement->execute();
			$results = $statement->fetchAll();
		}
		if ($typeSelect=='ExpTrsp')
		{
			$statement = $connection->prepare("SELECT ex.*, v1.LIBELLE_VILLE as VILLE_Depart, v2.LIBELLE_VILLE as VILLE_Arrivee, st.CODE_SOUS_TRAJET
                                                    FROM vehi_traj_voyg v, exp_transp ex, trajet_s_trajet tst, sous_trajet st
                                                    INNER JOIN ville as v1 on st.VILLE_Depart = v1.ID
                                                    INNER JOIN ville as v2 on st.VILLE_Arrivee = v2.ID
                                                    WHERE   v.TRAJET=tst.TRAJET
                                                    AND st.ID=tst.SOUS_TRAJET
                                                    AND ex.S_TRAJET=tst.SOUS_TRAJET
                                                    AND v.VOYAGE=:idVoyage" );
			$statement->bindValue('idVoyage',$idVoyage);
			$statement->execute();
			$results = $statement->fetchAll();
		}
		if(sizeof($results)>=1){
			return new Response(json_encode($results));
	
		}
		else {
			$response = array("code" =>  23,
					"message" =>"Aucun elements",
			);
			return new Response(json_encode($response));
		}
	}

	public function chargerVehiculeAction()
	{
		$em = $this->getDoctrine()->getManager();
		$connection = $em->getConnection();
		$params = $this->getRequest()->request->all();
		$idVoyage=$params['voyage'];
		$statement = $connection->prepare("SELECT v.id as idVehicule,v.Matricule_VEH as Matricule,v.Marque_VEH as Marque 
				                                 FROM  vehi_traj_voyg vtv,vehicule v
                                                  WHERE vtv.voyage=:voyage AND
                                                        vtv.vehicule=v.id" );
		$statement->bindValue('voyage',$idVoyage);
		$statement->execute();
		$results = $statement->fetchAll();
	
		if(sizeof($results)>=1){
			return new Response(json_encode($results));
	
		}
		else {
			$response = array("code" =>  404,
					"message" =>"Aucun  element Trouvee",
			);
			return new Response(json_encode($response));
		}
	}
	
	/**
	 *
	 *  @Secure(roles="ROLE_VALIDER_CHARGEMENT")
	 */
	
	public function validFeuilleChargementAction(){
		
		$em = $this->getDoctrine()->getManager();
		$connection = $em->getConnection();
		$params = $this->getRequest()->request->all();
		
		$voyage=$params['voyage'];
		
		$vehicule=$params['vehicule'];
		
		$numPlomb1=$params['numPlombage1'];
		$numPlomb2=$params['numPlombage2'];
		$numPlomb3=$params['numPlombage3'];
 		$numPlomb4=$params['numPlombage4'];

// 		$voyage=2;		
// 		$vehicule=1;
		
// 		$numPlomb1='1111';
// 		$numPlomb2='22212';
// 		$numPlomb3='3333';
// 		$numPlomb4='4444';
	 
		$statement = $connection->prepare("UPDATE vehi_traj_voyg SET numPlombage1=:numPlombage1,
				                                                     numPlombage2=:numPlombage2 ,
				                                                     numPlombage3=:numPlombage3,
				                                                     numPlombage4=:numPlombage4
				                                                   WHERE Voyage=:voyage
				                                                   And Vehicule=:vehicule;" );
		$statement->bindValue('voyage',$voyage);
		$statement->bindValue('vehicule',$vehicule);
		$statement->bindValue('numPlombage1',$numPlomb1);
		$statement->bindValue('numPlombage2',$numPlomb2);
		$statement->bindValue('numPlombage3',$numPlomb3);
		$statement->bindValue('numPlombage4',$numPlomb4);
	 
		$statement->execute();
		
		//get All Expedition with ExpedTRansp with nbreColis/Paletts and poids Total
	 
		$statement1 = $connection->prepare("SELECT DISTINCT(e.id),vtv.trajet as trajet,e.NBR_COLIS,e.NBR_PALETS,e.POIDS_EXP,e.code_Declaration,e.ETAT_EXP,um.TYPE_UNITE 
				                               FROM expedition e  
											     join exp_transp ex on (e.EXP_TRANSP=ex.ID or e.exptranstransit=ex.id)
												 join voyage v on (v.id=:voyage and v.Etat_Voyage='Validation')
												 join unite_manu um on (e.id=um.exept)
												 join exptransp_voyage exv on (exv.EXP_TRANSP=ex.ID and exv.voyage=:voyage )
												 join vehi_traj_voyg vtv on (vtv.voyage=:voyage AND vtv.vehicule=:vehicule ) " );
		$statement1->bindValue('voyage',$voyage);
		$statement1->bindValue('vehicule',$vehicule);
		$statement1->execute();
		$results = $statement1->fetchAll();
		
		 
		
		if(sizeof($results)>=1){
			
			
			$name="Feuille-Chargement-".$vehicule."-".$voyage;
			
			$entityVoyage = $em->getRepository('ComDaufinBundle:Voyage')->find($voyage);
			$entityVehic = $em->getRepository('ComDaufinBundle:Vehicule')->find($vehicule);
			$entityTrajet= $em->getRepository('ComDaufinBundle:Trajet')->find($results[0]['trajet']);
			$operateur = $this->getUser()->getPersonnel();
				
			$html2pdf = new \Html2Pdf_Html2Pdf('P','A4', 'fr', true, 'UTF-8', array(1, 2, 1, 1));
			$html2pdf->pdf->SetDisplayMode('real');
	
			$now=new \DateTime();
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
				                <td style=" margin-left: 15px;margin-top: 2px; width:150px;">  </td>
								<td style=" margin-left: 5px;margin-top: 2px; width:150px;">  </td>
								<td style=" margin-left: 5px;margin-top: 2px; width:150px;">Agence de Chargement  </td>
								<td style=" margin-left: 5px;margin-top: 2px; width:150px;"> Agence Casa </td>
           					</tr>
        			</table>
				 </page_header>';
					$content .='<div style="margin-top:100px; " ><br/><p style="text-align:center;font-size:20px"><b>Feuille de Chargement</b> </p>';
					$content.='<table align="center" style=" width:100%; " >';
					$content.='<tr style="font-size:13px; width:400px; text-align:center;  font-weight:bold">
		  				        <td></td>
							<td>Trajet</td>
							
		  				        <td > Voyage</td>
		  				        <td > Vehicule</td>
		  				   </tr>';
					$content.='<tr style="height: 120px; text-align:left; font-size:12px;">
		  						<td></td>
							 <td style=" padding:10px;"> Code Trajet : '.$entityTrajet->getCodeTrajet().' <br/> Libellee Trajet : '.$entityTrajet->getLibelleTrajet().' </td>
  				      
		  				        <td style=" padding:10px; "> Voyage : '.$entityVoyage->getId().' <br/> Date de Validation : '.$entityVoyage->getDatePlanif()->format('Y-m-d').'</td>
		  				        <td style=" padding:10px; "> Matricule : '.$entityVehic->getMatriculeVeh().' <br/> Poids Vehicule : '.$entityVehic->getPoidsPlein().'</td>
		  				   </tr>';
					
					$content.='</table>';
					$content.='<table align="center" style=" width:100%;">';
					$content.='<tr style=" text-align:center;  font-size:12px;   background-color: #DDDDFF;" >
					
			  						<td style=" margin-left: 5px;margin-top: 2px; width:120px;">Code Declaration</td>
					                <td style=" margin-left: 5px;margin-top: 2px; width:120px;">Colis/Palettes</td>
					                <td style=" margin-left: 5px;margin-top: 2px; width:120px;">Nbre.Colis</td>
							 <td style=" margin-left: 5px;margin-top: 2px; width:120px;">Nbre Palettes</td>
					                <td style=" margin-left: 5px;margin-top: 2px; width:120px;">Poids Total</td>
		  	
				
		            	 			 </tr>';
					$poidsTotal=0;
					$nbreColis=0;
					
					$entityVoyage->setEtatVoyage('En Route');
					$operVoyage=new OpererVoyage();
					$operVoyage->setDateOperation(new \DateTime());
					$operVoyage->setTypeOperation("En Route");
					$operVoyage->setPersonnel($operateur);
					$operVoyage->setVoyage($entityVoyage);
					$em->persist($operVoyage);
					
					
					
			
					foreach ($results as $res){
						//get and Changer Etat Expedition to Voyage
						
						$entityExped = $em->getRepository('ComDaufinBundle:Expedition')->find($res['id']);
						//$entityExped=new Expedition();
						
						if($entityExped->getEtatExp()=='Voyage'){
							
						$entityExped->setEtatExp("Voyage");
						$entityExped->setEnvDate(new \DateTime());
						// set trace in OpererExpedition
						
						$operationVoyage=new OpererExpedition();
						$operationVoyage->setPersonnel($operateur);
						$operationVoyage->setDateOperation(new \DateTime());
						$operationVoyage->setTypeOperation("Voyage");
						$operationVoyage->setExept($entityExped);
						
						$em->persist($operationVoyage);
						
						 $poidsTotal+=$res['POIDS_EXP'];
						 $nbreColis+=$res['NBR_COLIS'];
							 
						 
					
						$content.='<tr style="font-size:12px;border-bottom: 1px solid #000; ">
				  						<td style="text-align:center;   ">'.$res['code_Declaration'].'</td>
						                <td style=" text-align:center;  ">'.$res['TYPE_UNITE'].'</td>
						                <td style="text-align:center;   ">'.$res['NBR_COLIS'].'</td>
						                <td style=" text-align:center;  ">'.$res['NBR_PALETS'].'</td>
						                <td style="text-align:center;  ">'.$res['POIDS_EXP'].'</td>
				            	  </tr>';
						}
						}
						
						$em->flush();
			
						$content.='<tr style=" text-align:right;  font-size:13px; font-weight:bold;  background-color: #da2820; ">
			  				                <td></td> 
							                <td  style=" text-align:right; "> TOTAL Colis</td>
							                <td  style="text-align:right;">'.$nbreColis.'</td>
					  					    <td  style=" text-align:right; "> TOTAL Poids</td>
							                <td  style="text-align:right;">'.$poidsTotal.'</td>
							     </tr>';
						$content.='</table></div></page>';
							
						$html2pdf->writeHTML($content);				
						$html2pdf->Output('TicketTaxation/'.$name.'.pdf', 'F');
				
						$response = array("urlPDF" => "http://daufin.g-logmaroc.com/web/TicketTaxation/".$name.".pdf",
								"statut" => "1",);
						return new Response(json_encode($response));
			}
			else {
			   $response = array("code" =>  404,
					"message" =>"Aucune Expedition est planifier a ce voyage",
			    );
			return new Response(json_encode($response));
		}
		
	}
	
	/**
	 *
	 *  @Secure(roles="ROLE_ADD_VOYAGE")
	 */
	

	public function ajouterVoyageAction(){
		
		$em = $this->getDoctrine()->getManager();

		$parametres = $this->getRequest()->request->all();	
	
        $idTrajet = $parametres['idTrajet'];        
		$idVehicule = $parametres['idVehicule'];
		$idChauffeur= $parametres['idChauffeur'];
	    $date = $parametres['date'];
	    
	   // echo 'idVeh='.$idVehicule.' idCh='.$idChauffeur.'idTraj='.$idTrajet; 
	
		$user=$this->getUser();
		$personnel=$user->getPersonnel();	
	
	
		$voyage = new Voyage();
	
		$voyage->setEtatVoyage('Planification');
	    $voyage->setDatePlanif(new \DateTime($date));
		$em->persist($voyage);
		$em->flush();
	
		$trajet=$em->getRepository('ComDaufinBundle:Trajet')->find($idTrajet);
		$vehicule=$em->getRepository('ComDaufinBundle:Vehicule')->find($idVehicule);
		$chauffeur=$em->getRepository('ComDaufinBundle:Personnel')->find($idChauffeur);
	
		$vehiTrajVoyg = new VehiTrajVoyg();
		$vehiTrajVoyg->setvoyage($voyage);
		$vehiTrajVoyg->settrajet($trajet);
		$vehiTrajVoyg->setvehicule($vehicule);
		$vehiTrajVoyg->setChauffeur($chauffeur);
		$vehiTrajVoyg->setdatePasser(new \DateTime());
	
		$operVoyage=new OpererVoyage();
		$operVoyage->setVoyage($voyage);
		$operVoyage->setPersonnel($personnel);
		$operVoyage->setTypeOperation("Planification");
		$operVoyage->setDateOperation(new \DateTime());
		$em->persist($operVoyage);
	
		$em->persist($vehiTrajVoyg);
		$em->flush();
	 
		 // return $this->f
		
		$response = array("succes" =>  404,
				"message" =>"Le Voyage a ".$trajet->getLibelleTrajet()." , avec la vehicule ".$vehicule->getMatriculeVeh()." est crée",
		);
		return new Response(json_encode($response));
	 
	}
	
	public function getAllAgencesVilleAction(){
		
		$em = $this->getDoctrine()->getManager();
		$connection = $em->getConnection();
		$params = $this->getRequest()->request->all();
		
		$idVille=$params['idVille'];
		$statement = $connection->prepare("SELECT a.id as idAgence, a.Libelle_ag as libelleAgence
				                             FROM agence a where ville=:ville " );
		$statement->bindValue('ville',$idVille);
		$statement->execute();
		$results = $statement->fetchAll();
		
		if(sizeof($results)>=1){
			return new Response(json_encode($results));
		
		}
		else {
			$response = array("code" =>  404,
					"message" =>"Aucun élément Trouvee",
			);
			return new Response(json_encode($response));
		}
		
		
	}
	
	/**
	 *
	 *  @Secure(roles="ROLE_ADD_VOYAGE")
	 */
	
	public function formAddVoyageAction(){
		
		$em = $this->getDoctrine()->getManager();
		$trajets = $em->getRepository('ComDaufinBundle:Trajet')->findAll();
		$vehicules = $em->getRepository('ComDaufinBundle:Vehicule')->findAll();
		
		$connection = $em->getConnection();
		$statement = $connection->prepare("SELECT p.id as idChauffeur,p.Nom_PERS as nom,p.prenom_pers as prenom,p.matricule_pers as matricule
          		                             FROM  personnel p  WHERE p.fonction like '%convoyeur%' OR
				                                                      p.fonction like '%Ramasseur-Livreur%'
                                              " );
		//  WHERE p.fonction like '%convoyeur%'
		$statement->execute();
		$results = $statement->fetchAll();
		
		
		return $this->render('ComDaufinBundle:VehiTrajVoyg:newVoyage.html.twig', array(
				'trajets'=>$trajets,
				'vehicules'=>$vehicules,
				'chauffeurs'=>$results,
				 
		));
		
		
		
	}
//         private function stockChange($exped)
//         {
//             $em = $this->getDoctrine()->getManager();
//             $connection = $em->getConnection();
//             $statement = $connection->prepare("SELECT s.`ID`
//                                                FROM `stock` s, `unite_manu` um 
//                                                WHERE s.`UNITE_MANU`=um.`ID` and um.`EXEPT`=:EXEPT " );
// 		$statement->bindValue('EXEPT',$exped);
// 		$statement->execute();
// 		$results = $statement->fetchAll();
            
//             foreach($results as $result )
//             {
//                 $stock=$em->getRepository('ComDaufinBundle:Stock')->find($result);
//                 $stock->setTypeStock('Transite');
//             } 
            
//             $uniteManus=$em->getRepository('ComDaufinBundle:UniteManu')->find($exped->getId());

//             foreach($uniteManus as $uniteManu )
//             {
//                 $MStock=new MouvementStock();
//                 $MStock->setDateMouv(new \DateTime());
//                 $Mouv=$em->getRepository('ComDaufinBundle:Mouvement')->find(3);
//                 $MStock->setAgence($exped->getEnvAgence());
//                 $MStock->setUniteManu($uniteManu);
//                 $MStock->setMouvement($Mouv);
//                 $MStock->setPersonnel($this->getUser()->getPersonnel());
//                 $em->persist($MStock);
//             } 
//         }

}