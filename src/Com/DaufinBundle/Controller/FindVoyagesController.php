<?php

namespace Com\DaufinBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class FindVoyagesController extends Controller {

    public function indexAction() {

        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('ComDaufinBundle:Expedition')->findAll();
        $entityAgence = $em->getRepository('ComDaufinBundle:Agence')->findAll();
        $entitySecteur = $em->getRepository('ComDaufinBundle:Secteur')->findAll();
//        $connection = $em->getConnection();
        return $this->render('ComDaufinBundle:ReportVoyages:showAll.html.twig', array(
                    'entities' => $entities,
                    'entityAgence' => $entityAgence,
                    'entitySecteur' => $entitySecteur,
                        )
        );
    }

    public function FindVoyagesAction() {
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

        if ($codeDec != "") {
            $request = "SELECT    v.id as idVoyage
            ,v.Etat_Voyage as etatVoyage
            ,v.Date_planif as datePlanification
            ,v.Date_valid as dateValid
            ,t.Libelle_Trajet as libelleTrajet
            ,vh.matricule_veh as matriculeVehicule
            ,CONCAT(p.nom_Pers,' ',p.prenom_pers,' ',if(p.matricule_pers IS NULL ,'' ,p.matricule_pers )) as chauffeur
            FROM voyage v 
            left join vehi_traj_voyg as vtv on(vtv.voyage=v.id)
            left join vehicule as vh on(vtv.vehicule=vh.id)
            left join trajet as t on(vtv.trajet=t.id)
            left join personnel as p on(vtv.chauffeur=p.id )
            left join exptransp_voyage as ex_v on (v.id=ex_v.voyage)
            left join exp_transp as ex_t on (ex_t.id=ex_v.exp_transp)
            left outer join expedition as e on (ex_v.exp_transp =e.exp_transp)
            
            WHERE e.code_Declaration=:codeDec group by v.id ";

            $statement = $connection->prepare($request);
            $statement->bindValue('codeDec', $codeDec);
        } else {
            $request = "SELECT    v.id as idVoyage
            ,v.Etat_Voyage as etatVoyage
            ,v.Date_planif as datePlanification
            ,v.Date_valid as dateValid
            ,t.Libelle_Trajet as libelleTrajet
            ,vh.matricule_veh as matriculeVehicule
            ,CONCAT(p.nom_Pers,' ',p.prenom_pers,' ',if(p.matricule_pers IS NULL ,'' ,p.matricule_pers )) as chauffeur
            FROM voyage v 
            left join vehi_traj_voyg as vtv on(vtv.voyage=v.id)
            left join vehicule as vh on(vtv.vehicule=vh.id)
            left join trajet as t on(vtv.trajet=t.id)
            left join personnel as p on(vtv.chauffeur=p.id )
            left join exptransp_voyage as ex_v on (v.id=ex_v.voyage)
            left join exp_transp as ex_t on (ex_t.id=ex_v.exp_transp)
            left outer join expedition as e on (ex_v.exp_transp =e.exp_transp)

            WHERE (e.DATE_DECL BETWEEN :dateCreationDu AND :dateCreationAu)  ";

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
            $request = $request . " group by v.id ";
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
        }
        $statement->execute();
        $results = $statement->fetchAll();
        if (sizeof($results) >= 1) {
            $response = array();
            if ($codeDec != "") 
            {
                $request2 = "SELECT  ex_v.voyage as idVoyage
            ,count(e.id) as nbrExp
            ,sum(poids_exp) as poidsTotal
            ,sum(nbr_colis) as nbrColis
            
            FROM expedition e 
             join exptransp_voyage as ex_v on ((e.exp_transp=ex_v.exp_transp ) and (e.exp_transp is not NULL))
            
            WHERE ex_v.voyage=:idVoyage  group by ex_v.voyage";

            $statement2 = $connection->prepare($request2);

            $statement2->bindValue('idVoyage', $results[0]['idVoyage']);
            $statement2->execute();
            $results2 = $statement2->fetchAll();
            $response[] = array_merge(
                            array(
                                "idVoyage" => $results[0]['idVoyage'],
                                "etatVoyage" => $results[0]['etatVoyage'],
                                "datePlanification" => $results[0]['datePlanification'],
                                "dateValid" => $results[0]['dateValid'],
                                "libelleTrajet" => $results[0]['libelleTrajet'],
                                "matriculeVehicule" => $results[0]['matriculeVehicule'],
                                "chauffeur" => $results[0]['chauffeur'],
                                "nbrExp" => $results2[0]['nbrExp'],
                                "poidsTotal" => $results2[0]['poidsTotal'],
                                "nbrColis" => $results2[0]['nbrColis'],
                    ));
            }
            else 
            {
                $ids=array();
                foreach ($results as $value) {
                   array_push($ids, $value['idVoyage']);
                }
                
                $inQuery = implode(',', array_fill(0, count($ids), '?'));
                $request2 = "SELECT  ex_v.voyage as idVoyage
                                ,count(e.id) as nbrExp
                                ,sum(poids_exp) as poidsTotal
                                ,sum(nbr_colis) as nbrColis
                                
                                FROM expedition e 
                                 join exptransp_voyage as ex_v 
                                 on ((e.exp_transp=ex_v.exp_transp ) and (e.exp_transp is not NULL))
                                
                                WHERE ex_v.voyage IN(" . $inQuery . ")  group by ex_v.voyage";
                $statement2 = $connection->prepare($request2);
                foreach ($ids as $k => $id)
                {
                    $statement2->bindValue(($k+1), $id);
                }
                $statement2->execute();
                $results2 = $statement2->fetchAll();
                $k=0;
                foreach ($results as $res) 
                {
                    $response[] = array_merge(
                            array(
                                "idVoyage" => $res['idVoyage'],
                                "etatVoyage" => $res['etatVoyage'],
                                "datePlanification" => $res['datePlanification'],
                                "dateValid" => $res['dateValid'],
                                "libelleTrajet" => $res['libelleTrajet'],
                                "matriculeVehicule" => $res['matriculeVehicule'],
                                "chauffeur" => $res['chauffeur'],
                                "nbrExp" => $results2[$k]['nbrExp'],
                                "poidsTotal" => $results2[$k]['poidsTotal'],
                                "nbrColis" => $results2[$k]['nbrColis'],
                    ));
                    $k++;
                }
            }

            return new Response(json_encode($response));
        } else {

            $response = array("error" => 27,
                "message" => "Aucune Expedition trouvee",);
            return new Response(json_encode($response));
        }
    }

}
