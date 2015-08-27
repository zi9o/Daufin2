<?php

namespace Com\DaufinBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class FindServicesController extends Controller {

    public function indexAction() {

        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('ComDaufinBundle:Expedition')->findAll();
        $entityAgence = $em->getRepository('ComDaufinBundle:Agence')->findAll();
        $entitySecteur = $em->getRepository('ComDaufinBundle:Secteur')->findAll();
//        $connection = $em->getConnection();
        return $this->render('ComDaufinBundle:ReportServices:showAll.html.twig', array(
                    'entities' => $entities,
                    'entityAgence' => $entityAgence,
                    'entitySecteur' => $entitySecteur,
                        )
        );
    }

    public function indexSyntheseAction() {

        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('ComDaufinBundle:Expedition')->findAll();
        $entityAgence = $em->getRepository('ComDaufinBundle:Agence')->findAll();
        $entitySecteur = $em->getRepository('ComDaufinBundle:Secteur')->findAll();
//        $connection = $em->getConnection();
        return $this->render('ComDaufinBundle:ReportServices:showSynthese.html.twig', array(
                    'entities' => $entities,
                    'entityAgence' => $entityAgence,
                    'entitySecteur' => $entitySecteur,
                        )
        );
    }

    public function FindServicesAction() {
        $em = $this->getDoctrine()->getManager();

        $connection = $em->getConnection();

        $params = $this->getRequest()->request->all();

        $codeDec = $params['codeDec'];
        $dateCreationDu = $params['dateCreationDu'];
        $dateCreationAu = $params['dateCreationAu'];
        $idAgenceDu = $params['idAgenceDu'];
        $idAgenceAu = $params['idAgenceAu'];
        $idSecteurDu = $params['idSecteurDu'];
        $idSecteurAu = $params['idSecteurAu'];
        $isSimple = $params['isSimple'];
        $isCheque = $params['isCheque'];
        $isTraite = $params['isTraite'];
        $isCrbt = $params['isCrbt'];
        $isBon_livr = $params['isBon_livr'];

        if ($codeDec != "") {

            $expedition = $em->getRepository('ComDaufinBundle:Expedition')->findOneByCodeDeclaration($codeDec);
            $cheque = $em->getRepository('ComDaufinBundle:Cheque')->findOneByExept($expedition->getId());
            $Bl = $em->getRepository('ComDaufinBundle:BLivraisonM')->findOneByExept($expedition->getId());
            $Crbt = $em->getRepository('ComDaufinBundle:Crbt')->findOneByExept($expedition->getId());
            $Traite = $em->getRepository('ComDaufinBundle:Traite')->findOneByExept($expedition->getId());
            if ($Bl != null) {
                $bl_Date = $Bl->getDateValid()->format('Y-m-d h:m');
                $bl_num = $Bl->getNumBl();
            } else {
                $bl_Date = null;
                $bl_num = '';
            }
            if ($cheque != null) {
                $cheque_num = $cheque->getNumCheque();
                $cheque_mt = $cheque->getMontantChq();
            } else {
                $cheque_num = null;
                $cheque_mt = '';
            }
            if ($Crbt != null) {
                $crbt_Date = $Crbt->getDateCrbt();
                $crbt_mt = $Crbt->getMontantCrbt();
            } else {
                $crbt_Date = null;
                $crbt_mt = '';
            }
            if ($Traite != null) {
                $traite_Date = $Traite->getDateTraite();
                $traite_mt = $Traite->getMontantTrt();
            } else {
                $traite_Date = null;
                $traite_mt = '';
            }
            $response[] = array_merge(
                    array(
                        "date_declaration" => $expedition->getDateDecl()->format('Y-m-d h:m'),
                        "code_dec" => $expedition->getCodeDeclaration(),
                        "Port" => $expedition->getMdPort(),
                        "EtatReglement" => $expedition->getEtatRegl(),
                        "Montant" => $expedition->getTotalMontant(),
                        "Statut" => $expedition->getEtatExp(),
                        "nbrColis" => $expedition->getNbrColis(),
                        "bl_Date" => $bl_Date,
                        "bl_num" => $bl_num,
                        "cheque_num" => $cheque_num,
                        "cheque_mt" => $cheque_mt,
                        "crbt_Date" => $crbt_Date,
                        "crbt_mt" => $crbt_mt,
                        "traite_Date" => $traite_Date,
                        "traite_mt" => $traite_mt,
            ));
            return new Response(json_encode($response));
        } else {
            if ($isSimple == 0) {
                $request = "SELECT distinct e.DATE_DECL as date_declaration,
                e.code_Declaration as code_dec,
                e.md_port as Port,
                e.TOTAL_MONTANT as Montant,
                e.Etat_Regl as EtatReglement,
                e.ETAT_EXP as Statut ,
                e.nbr_colis as nbrColis";

                if ($isBon_livr == 1) {
                    $request = $request . ", bl.dateValid as bl_Date,bl.num_bl as bl_num";
                }
                if ($isCheque == 1) {
                    $request = $request . ",c.num_cheque as cheque_num,c.montant_chq as cheque_mt";
                }
                if ($isCrbt == 1) {
                    $request = $request . ",cr.dateValid as crbt_Date,cr.montant_crbt as crbt_mt";
                }
                if ($isTraite == 1) {
                    $request = $request . ",t.dateValid as traite_Date,t.montant_trt as traite_mt";
                }

                $request = $request . " FROM expedition e 
                join suiv_service as s on (s.exept=e.id) ";

                if ($isBon_livr == 1) {
                    $request = $request . " left  join b_livraison_m as bl on (bl.exept=e.id) ";
                }
                if ($isCheque == 1) {
                    $request = $request . " left join cheque as c on (c.exept=e.id) ";
                }
                if ($isCrbt == 1) {
                    $request = $request . " left join crbt as cr on (cr.exept=e.id) ";
                }
                if ($isTraite == 1) {
                    $request = $request . " left join traite as t on (t.exept=e.id)";
                }
                $request = $request . " WHERE (e.DATE_DECL BETWEEN :dateCreationDu AND :dateCreationAu) ";

                if ($idAgenceDu != "none") {
                    $request = $request . " and e.envAgence=:idAgenceDu";
                }
                if ($idAgenceAu != "none") {
                    $request = $request . " and e.recAgence=:idAgenceAu";
                }
                if ($idSecteurDu != "none") {
                    $request = $request . " and e.envSecteur=:idSecteurDu";
                }
                if ($idSecteurAu != "none") {
                    $request = $request . " and e.recSecteur=:idSecteurAu";
                }

                $request = $request . " limit 100";


                $statement = $connection->prepare($request);

                $statement->bindValue('dateCreationDu', $dateCreationDu);
                $statement->bindValue('dateCreationAu', $dateCreationAu);

                if ($idAgenceDu != "none") {
                    $statement->bindValue('idAgenceDu', $idAgenceDu);
                }
                if ($idAgenceAu != "none") {
                    $statement->bindValue('idAgenceAu', $idAgenceAu);
                }
                if ($idSecteurDu != "none") {
                    $statement->bindValue('idSecteurDu', $idSecteurDu);
                }
                if ($idSecteurAu != "none") {
                    $statement->bindValue('idSecteurAu', $idSecteurAu);
                }
            } else {
                $request = "SELECT distinct e.DATE_DECL as date_declaration,
                e.code_Declaration as code_dec,
                e.md_port as Port,
                e.TOTAL_MONTANT as Montant,
                e.Etat_Regl as EtatReglement,
                e.ETAT_EXP as Statut,
                e.nbr_colis as nbrColis
                
                FROM expedition e 
                left join suiv_service as s on (s.exept=e.id) ";
                $request = $request . " WHERE (e.DATE_DECL BETWEEN :dateCreationDu AND :dateCreationAu) ";

                if ($idAgenceDu != "none") {
                    $request = $request . " and e.envAgence=:idAgenceDu";
                }
                if ($idAgenceAu != "none") {
                    $request = $request . " and e.recAgence=:idAgenceAu";
                }
                if ($idSecteurDu != "none") {
                    $request = $request . " and e.envSecteur=:idSecteurDu";
                }
                if ($idSecteurAu != "none") {
                    $request = $request . " and e.recSecteur=:idSecteurAu";
                }
                $statement = $connection->prepare($request);

                $statement->bindValue('dateCreationDu', $dateCreationDu);
                $statement->bindValue('dateCreationAu', $dateCreationAu);

                if ($idAgenceDu != "none") {
                    $statement->bindValue('idAgenceDu', $idAgenceDu);
                }
                if ($idAgenceAu != "none") {
                    $statement->bindValue('idAgenceAu', $idAgenceAu);
                }
                if ($idSecteurDu != "none") {
                    $statement->bindValue('idSecteurDu', $idSecteurDu);
                }
                if ($idSecteurAu != "none") {
                    $statement->bindValue('idSecteurAu', $idSecteurAu);
                }
                $request = $request . " limit 100";
            }
        }
        $statement->execute();
        $results = $statement->fetchAll();
        if (sizeof($results) >= 1) {
            $response = array();
            $out = array();
            $out1 = array();
            $out2 = array();
            $out3 = array();
            $out4 = array();
            $test1 = false;
            $test2 = false;
            $test3 = false;
            $test4 = false;
            if ($isSimple == 0) {
                foreach ($results as $res) {




                    $out = array_merge(
                            array(
                                "date_declaration" => $res['date_declaration'],
                                "code_dec" => $res['code_dec'],
                                "Port" => $res['Port'],
                                "Montant" => $res['Montant'],
                                "EtatReglement" => $res['EtatReglement'],
                                "Statut" => $res['Statut'],
                                "nbrColis" => $res['nbrColis'],
                            )
                    );
                    if ($isBon_livr == 1) {
                        $for_Bl = array("bl_Date" => $res['bl_Date'],
                            "bl_num" => $res['bl_num'],);
                        $out1 = array_merge($out, $for_Bl);
                        $test1 = true;
                    }
                    if ($isCheque == 1) {
                        $for_cheque = array("cheque_num" => $res['cheque_num'],
                            "cheque_mt" => $res['cheque_mt'],);
                        if (!empty($out1)) {
                            $out2 = array_merge($out1, $for_cheque);
                        } else {
                            $out2 = array_merge($out, $for_cheque);
                        }
                        $test2 = true;
                    }
                    if ($isCrbt == 1) {
                        $for_Crbt = array("crbt_Date" => $res['crbt_Date'],
                            "crbt_mt" => $res['crbt_mt'],);
                        if (!empty($out2)) {
                            $out3 = array_merge($out2, $for_Crbt);
                        } else {
                            if (!empty($out1)) {
                                $out3 = array_merge($out1, $for_Crbt);
                            } else {
                                $out3 = array_merge($out, $for_Crbt);
                            }
                        }
                        $test3 = true;
                    }
                    if ($isTraite == 1) {
                        $for_Traite = array("traite_Date" => $res['traite_Date'],
                            "traite_mt" => $res['traite_mt'],);
                        if (!empty($out3)) {
                            $out4 = array_merge($out3, $for_Traite);
                        } else {
                            if (!empty($out2)) {
                                $out4 = array_merge($out2, $for_Traite);
                            } else {
                                if (!empty($out1)) {
                                    $out4 = array_merge($out1, $for_Traite);
                                } else {
                                    $out4 = array_merge($out, $for_Traite);
                                }
                            }
                        }
                        $test4 = true;
                    }
                    if ($test4 == true) {
                        $response[] = $out4;
                    } else if ($test3 == true) {
                        $response[] = $out3;
                    } else if ($test2 == true) {
                        $response[] = $out2;
                    } else if ($test1 == true) {
                        $response[] = $out1;
                    }
//                    $response[] = array_merge(
//                            array(
//                                "date_declaration" => $res['date_declaration'],
//                                "code_dec" => $res['code_dec'],
//                                "Port" => $res['Port'],
//                                "Statut" => $res['Statut'],
//                                "bl_Date" => $res['bl_Date'],
//                                "bl_num" => $res['bl_num'],
//                                "cheque_num" => $res['cheque_num'],
//                                "cheque_mt" => $res['cheque_mt'],
//                                "crbt_Date" => $res['crbt_Date'],
//                                "crbt_mt" => $res['crbt_mt'],
//                                "traite_Date" => $res['traite_Date'],
//                                "traite_mt" => $res['traite_mt'],
//                    ));
                }
            } else {
                foreach ($results as $res) {
                    $response[] = array_merge(
                            array(
                                "date_declaration" => $res['date_declaration'],
                                "code_dec" => $res['code_dec'],
                                "Port" => $res['Port'],
                                "Montant" => $res['Montant'],
                                "EtatReglement" => $res['EtatReglement'],
                                "Statut" => $res['Statut'],
                                "nbrColis" => $res['nbrColis'],
                    ));
                }
            }

            return new Response(json_encode($response));
        } else {

            $response = array("error" => 40,
                "message" => "Aucune Expedition trouvée",);
            return new Response(json_encode($response));
        }
    }

    public function FindSyntheseServicesAction() {
        $em = $this->getDoctrine()->getManager();

        $connection = $em->getConnection();

        $params = $this->getRequest()->request->all();

        $dateCreationDu = $params['dateCreationDu'];
        $dateCreationAu = $params['dateCreationAu'];
        $idAgenceDu = $params['idAgenceDu'];
        $idAgenceAu = $params['idAgenceAu'];
        $idSecteurDu = $params['idSecteurDu'];
        $idSecteurAu = $params['idSecteurAu'];
        $isSimple = $params['isSimple'];
        $isCheque = $params['isCheque'];
        $isTraite = $params['isTraite'];
        $isCrbt = $params['isCrbt'];
        $isBon_livr = $params['isBon_livr'];

        if ($isSimple == 0) 
        {
            $request = "SELECT  count( e.id) as nbrDec,
                (select a.libelle_ag from agence a where a.id=e.envAgence) as AgenceD,
                (select a.libelle_ag from agence a where a.id=e.recAgence)  as AgenceR,
                sum(case  when e.md_port='portDu' then 1 else 0 end) as nb_portDu,
                sum(case  when e.md_port='portDu' then e.total_montant else 0 end) as PortDU,
                sum(case  when e.md_port='portPaye' then 1 else 0 end) as nb_portPaye,
                sum(case  when e.md_port='portPaye' then e.total_montant else 0 end) as PortPaye,
                sum(case e.etat_regl when 'Reglee' then 1 else 0 end )  as Reglee,
                sum( case e.etat_regl when 'nonReglee' then 1 else 0 end) as NonReglee";

            
            if ($isCheque == 1) {
                $request = $request . ",sum(case  when e.id=c.exept then c.montant_chq else 0 end) as cheque_mt";
            }
            if ($isCrbt == 1) {
                $request = $request . ",sum(case  when e.id=cr.exept then cr.montant_crbt else 0 end) as crbt_mt";
            }
            if ($isTraite == 1) {
                $request = $request . ",sum(case  when e.id=t.exept then t.montant_trt else 0 end) as traite_mt";
            }

            $request = $request . " FROM expedition e  ";

            if ($isBon_livr == 1) {
                $request = $request . " left join b_livraison_m as bl on (bl.exept=e.id) ";
            }
            if ($isCheque == 1) {
                $request = $request . " left join cheque as c on (c.exept=e.id) ";
            }
            if ($isCrbt == 1) {
                $request = $request . " left join crbt as cr on (cr.exept=e.id) ";
            }
            if ($isTraite == 1) {
                $request = $request . " left join traite as t on (t.exept=e.id) ";
            }

            $request = $request . " WHERE (e.DATE_DECL BETWEEN :dateCreationDu AND :dateCreationAu) ";

            if ($idAgenceDu != "none") {
                $request = $request . " and e.envAgence=:idAgenceDu";
            }
            if ($idAgenceAu != "none") {
                $request = $request . " and e.recAgence=:idAgenceAu";
            }
            if ($idSecteurDu != "none") {
                $request = $request . " and e.envSecteur=:idSecteurDu";
            }
            if ($idSecteurAu != "none") {
                $request = $request . " and e.recSecteur=:idSecteurAu";
            }
            $request = $request . " group by e.envAgence,e.recAgence ";

            //$request=$request." limit 100";

            $request2 = "SELECT count(distinct e.id) ";

            if ($isBon_livr == 1) {
                $request2 = $request2 . ",sum(case when (s.exept=e.id and s.rub=7) then s.prix_ttc else 0 end) as prix_BL";
            }
            if ($isCheque == 1) {
                $request2 = $request2 . ",sum(case when (s.exept=e.id and s.rub=8) then s.prix_ttc else 0 end) as prix_cheque";
            }
            if ($isCrbt == 1) {
                $request2 = $request2 . ",sum(case when (s.exept=e.id and s.rub=10)  then s.prix_ttc else 0 end) as prix_crbt";
            }
            if ($isTraite == 1) {
                $request2 = $request2 . ",sum(case when (e.id=s.exept and s.rub=9)  then s.prix_ttc else 0 end) as prix_traite";
            }

            $request2 = $request2 . " FROM expedition as e left join suiv_service as s on (s.exept=e.id ) ";

            $request2 = $request2 . " WHERE (e.DATE_DECL BETWEEN :dateCreationDu AND :dateCreationAu) ";

            if ($idAgenceDu != "none") {
                $request2 = $request2 . " and e.envAgence=:idAgenceDu";
            }
            if ($idAgenceAu != "none") {
                $request2 = $request2 . " and e.recAgence=:idAgenceAu";
            }
            if ($idSecteurDu != "none") {
                $request2 = $request2 . " and e.envSecteur=:idSecteurDu";
            }
            if ($idSecteurAu != "none") {
                $request2 = $request2 . " and e.recSecteur=:idSecteurAu";
            }
            $request2 = $request2 . " group by e.envAgence,e.recAgence ";

            $statement = $connection->prepare($request);

            $statement->bindValue('dateCreationDu', $dateCreationDu);
            $statement->bindValue('dateCreationAu', $dateCreationAu);

            if ($idAgenceDu != "none") {
                $statement->bindValue('idAgenceDu', $idAgenceDu);
            }
            if ($idAgenceAu != "none") {
                $statement->bindValue('idAgenceAu', $idAgenceAu);
            }
            if ($idSecteurDu != "none") {
                $statement->bindValue('idSecteurDu', $idSecteurDu);
            }
            if ($idSecteurAu != "none") {
                $statement->bindValue('idSecteurAu', $idSecteurAu);
            }


            $statement2 = $connection->prepare($request2);

            $statement2->bindValue('dateCreationDu', $dateCreationDu);
            $statement2->bindValue('dateCreationAu', $dateCreationAu);

            if ($idAgenceDu != "none") {
                $statement2->bindValue('idAgenceDu', $idAgenceDu);
            }
            if ($idAgenceAu != "none") {
                $statement2->bindValue('idAgenceAu', $idAgenceAu);
            }
            if ($idSecteurDu != "none") {
                $statement2->bindValue('idSecteurDu', $idSecteurDu);
            }
            if ($idSecteurAu != "none") {
                $statement2->bindValue('idSecteurAu', $idSecteurAu);
            }
        } else {
            $request = "SELECT  count( e.id) as nbrDec,
                (select libelle_ag from agence where id=e.envAgence) as AgenceD,
                (select libelle_ag from agence where id=e.recAgence)  as AgenceR,
                sum(case md_port when 'portDu' then 1 else 0 end) as nb_portDu,
                sum(case md_port when 'portDu' then total_montant else 0 end) as PortDU,
                sum(case md_port when 'portPaye' then 1 else 0 end) as nb_portPaye,
                sum(case md_port when 'portPaye' then total_montant else 0 end) as PortPaye,
               sum(case etat_regl when 'Reglee' then 1 else 0 end )  as Reglee,
                sum( case etat_regl when 'nonReglee' then 1 else 0 end) as NonReglee
                
                FROM expedition e 
                WHERE (e.DATE_DECL BETWEEN :dateCreationDu AND :dateCreationAu) ";

            if ($idAgenceDu != "none") {
                $request = $request . " and e.envAgence=:idAgenceDu";
            }
            if ($idAgenceAu != "none") {
                $request = $request . " and e.recAgence=:idAgenceAu";
            }
            if ($idSecteurDu != "none") {
                $request = $request . " and e.envSecteur=:idSecteurDu";
            }
            if ($idSecteurAu != "none") {
                $request = $request . " and e.recSecteur=:idSecteurAu";
            }

            $request = $request . " group by e.envAgence,e.recAgence ";


            $statement = $connection->prepare($request);

            $statement->bindValue('dateCreationDu', $dateCreationDu);
            $statement->bindValue('dateCreationAu', $dateCreationAu);

            if ($idAgenceDu != "none") {
                $statement->bindValue('idAgenceDu', $idAgenceDu);
            }
            if ($idAgenceAu != "none") {
                $statement->bindValue('idAgenceAu', $idAgenceAu);
            }
            if ($idSecteurDu != "none") {
                $statement->bindValue('idSecteurDu', $idSecteurDu);
            }
            if ($idSecteurAu != "none") {
                $statement->bindValue('idSecteurAu', $idSecteurAu);
            }

//                $request=$request." limit 100";
        }

        $statement->execute();
        $results = $statement->fetchAll();
        if (sizeof($results) >= 1) {
            $response = array();
            $out = array();
            $out1 = array();
            $out2 = array();
            $out3 = array();
            $out4 = array();
            $test1 = false;
            $test2 = false;
            $test3 = false;
            $test4 = false;
            if ($isSimple == 0) 
            {
                $statement2->execute();
                $results2 = $statement2->fetchAll();
                for ($i = 0; $i < count($results); ++$i) {




                    $out = array_merge(
                            array(
                                "nbrDec" => $results[$i]['nbrDec'],
                                "AgenceD" => $results[$i]['AgenceD'],
                                "AgenceR" => $results[$i]['AgenceR'],
                                "nb_portDu" => $results[$i]['nb_portDu'],
                                "portDu" => $results[$i]['PortDU'],
                                "nb_portPaye" => $results[$i]['nb_portPaye'],
                                "portPaye" => $results[$i]['PortPaye'],
                                "nb_Reglee" => $results[$i]['Reglee'],
                                "nb_NonReglee" => $results[$i]['NonReglee'],
                            )
                    );
                    if ($isBon_livr == 1) {
                        $for_Bl = array("prix_BL" => $results2[$i]['prix_BL'],);
                        $out1 = array_merge($out, $for_Bl);
                        $test1 = true;
                    }
                    if ($isCheque == 1) {
                        $for_cheque = array("cheque_mt" => $results[$i]['cheque_mt'],
                            "prix_cheque" => $results2[$i]['prix_cheque'],);
                        if (!empty($out1)) {
                            $out2 = array_merge($out1, $for_cheque);
                        } else {
                            $out2 = array_merge($out, $for_cheque);
                        }
                        $test2 = true;
                    }
                    if ($isCrbt == 1) {
                        $for_Crbt = array("crbt_mt" => $results[$i]['crbt_mt'],
                            "prix_crbt" => $results2[$i]['prix_crbt'],);
                        if (!empty($out2)) {
                            $out3 = array_merge($out2, $for_Crbt);
                        } else {
                            if (!empty($out1)) {
                                $out3 = array_merge($out1, $for_Crbt);
                            } else {
                                $out3 = array_merge($out, $for_Crbt);
                            }
                        }
                        $test3 = true;
                    }
                    if ($isTraite == 1) {
                        $for_Traite = array("traite_mt" => $results[$i]['traite_mt'],
                            "prix_traite" => $results2[$i]['prix_traite'],);
                        if (!empty($out3)) {
                            $out4 = array_merge($out3, $for_Traite);
                        } else {
                            if (!empty($out2)) {
                                $out4 = array_merge($out2, $for_Traite);
                            } else {
                                if (!empty($out1)) {
                                    $out4 = array_merge($out1, $for_Traite);
                                } else {
                                    $out4 = array_merge($out, $for_Traite);
                                }
                            }
                        }
                        $test4 = true;
                    }
                    if ($test4 == true) {
                        $response[] = $out4;
                    } else if ($test3 == true) {
                        $response[] = $out3;
                    } else if ($test2 == true) {
                        $response[] = $out2;
                    } else if ($test1 == true) {
                        $response[] = $out1;
                    }
                }
            } else {
                foreach ($results as $res) {
                    $response[] = array_merge(
                            array(
                                "nbrDec" => $res['nbrDec'],
                                "AgenceD" => $res['AgenceD'],
                                "AgenceR" => $res['AgenceR'],
                                "nb_portDu" => $res['nb_portDu'],
                                "portDu" => $res['PortDU'],
                                "nb_portPaye" => $res['nb_portPaye'],
                                "portPaye" => $res['PortPaye'],
                                "nb_Reglee" => $res['Reglee'],
                                "nb_NonReglee" => $res['NonReglee'],
                    ));
                }
            }

            return new Response(json_encode($response));
        } else {

            $response = array("error" => 40,
                "message" => "Aucune Expedition trouvée",);
            return new Response(json_encode($response));
        }
    }

}
