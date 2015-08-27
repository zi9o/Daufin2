<?php

namespace Com\DaufinBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class FindExpeditionController extends Controller {

    public function indexAction() {

        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('ComDaufinBundle:Expedition')->findAll();
        $entityAgence = $em->getRepository('ComDaufinBundle:Agence')->findAll();
        $entitySecteur = $em->getRepository('ComDaufinBundle:Secteur')->findAll();
//        $connection = $em->getConnection();
        return $this->render('ComDaufinBundle:ReportExpedition:showAll.html.twig', array(
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
        return $this->render('ComDaufinBundle:ReportExpedition:showSynthese.html.twig', array(
                    'entities' => $entities,
                    'entityAgence' => $entityAgence,
                    'entitySecteur' => $entitySecteur,
                        )
        );
    }

    public function FindExpeditionAction() {
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
        $mode = $params['mode'];

        if ($codeDec != "") {
            $request = "SELECT 
                DATE_DECL as date_declaration,
                code_Declaration as code_dec,
                NBR_COLIS as nbColis,
                NBR_PALETS as nb_Pals,
                POIDS_EXP as poid,
                ETAT_EXP as Etat_expedition,
                ETAT_REGL as Etat_Reglement 
             FROM expedition e WHERE e.code_Declaration=:codeDec";

            $statement = $connection->prepare($request);
            $statement->bindValue('codeDec', $codeDec);
        } else {
            $request = "SELECT 
                DATE_DECL as date_declaration,
                code_Declaration as code_dec,
                NBR_COLIS as nbColis,
                NBR_PALETS as nb_Pals,
                POIDS_EXP as poid,
                ETAT_EXP as Etat_expedition,
                ETAT_REGL as Etat_Reglement 
             FROM expedition e WHERE (e.DATE_DECL BETWEEN :dateCreationDu AND :dateCreationAu) and e.MD_PORT=:mode ";

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
            $statement->bindValue('mode', $mode);

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
            foreach ($results as $res) {
                $response[] = array_merge(
                        array(
                            "date_declaration" => $res['date_declaration'],
                            "code_dec" => $res['code_dec'],
                            "nbColis" => $res['nbColis'],
                            "nb_Pals" => $res['nb_Pals'],
                            "poid" => $res['poid'],
                            "Etat_expedition" => $res['Etat_expedition'],
                            "Etat_Reglement" => $res['Etat_Reglement'],
                ));
            }

            return new Response(json_encode($response));
        } else {

            $response = array("error" => 40,
                "message" => "Aucune Expedition trouvée",);
            return new Response(json_encode($response));
        }
    }

    public function FindSyntheseExpeditionAction() {
        $em = $this->getDoctrine()->getManager();

        $connection = $em->getConnection();

        $params = $this->getRequest()->request->all();

        $dateCreationDu = $params['dateCreationDu'];
        $dateCreationAu = $params['dateCreationAu'];
        $idAgenceDu = $params['idAgenceDu'];
        $idAgenceAu = $params['idAgenceAu'];
        $idSecteurDu = $params['idSecteurDu'];
        $idSecteurAu = $params['idSecteurAu'];

        $request = "SELECT count(e.id) as nbrDec,
                (select libelle_ag from agence where id=e.envAgence) as AgenceD,
                (select libelle_ag from agence where id=e.recAgence)  as AgenceR,
                sum(NBR_COLIS) as nbColis,
                sum(POIDS_EXP) as poid,
                sum(case md_port when 'portDu' then 1 else 0 end) as PortDU,
                sum(case md_port when 'portPaye' then 1 else 0 end) as PortPaye
             FROM expedition e WHERE (e.DATE_DECL BETWEEN :dateCreationDu AND :dateCreationAu) ";

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
//        $request = $request . " limit 100";
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

        $statement->execute();
        $results = $statement->fetchAll();
        if (sizeof($results) >= 1) {
            $response = array();
            foreach ($results as $res) {



                $response[] = array_merge(
                        array(
                            "nbrDec" => $res['nbrDec'],
                            "AgenceD" => $res['AgenceD'],
                            "AgenceR" => $res['AgenceR'],
                            "nbColis" => $res['nbColis'],
                            "poid" => $res['poid'],
                            "PortDU" => $res['PortDU'],
                            "PortPaye" => $res['PortPaye'],
                ));
            }

            return new Response(json_encode($response));
        } else {

            $response = array("error" => 40,
                "message" => "Aucune Expedition trouvée",);
            return new Response(json_encode($response));
        }
    }

}
