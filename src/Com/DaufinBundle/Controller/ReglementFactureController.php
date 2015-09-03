<?php

namespace Com\DaufinBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Com\DaufinBundle\Entity\Client;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Com\DaufinBundle\Entity\ReglementFacture;
use Com\DaufinBundle\Entity\Reglement;
use Com\DaufinBundle\Form\ReglementFactureType;

/**
 * ReglementFacture controller.
 *
 * @Route("/com_RegleFacture")
 */
class ReglementFactureController extends Controller {

    /**
     * Lists all ReglementFacture entities.
     *
     * @Route("/", name="com_RegleFacture")
     * @Method("GET")
     * @Template()
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ComDaufinBundle:Reglement')->findAll();

        return $this->render('ComDaufinBundle:ReglementFacture:index.html.twig', array(
                    'entities' => $entities,
        ));
    }

    public function indexAddReglementAction() {
        $em = $this->getDoctrine()->getManager();

        $entitiesCompte = $em->getRepository('ComDaufinBundle:Client')->findBy(array('typeClient' => 'Compte'));
        $entitiesParticulier = $em->getRepository('ComDaufinBundle:Client')->findBy(array('typeClient' => 'Particulier'));

        return $this->render('ComDaufinBundle:ReglementFacture:new.html.twig', array(
                    'entitiesCompte' => $entitiesCompte,
                    'entitiesParticulier' => $entitiesParticulier,
        ));
    }

    public function FindindexAddReglementAction() {
        $em = $this->getDoctrine()->getManager();

        $connection = $em->getConnection();

        $params = $this->getRequest()->request->all();

        $dateCreationDu = $params['dateCreationDu'];
        $dateCreationAu = $params['dateCreationAu'];
        $CodeClientCompte = $params['CodeClientCompte'];
        $CodeClientParticulier = $params['CodeClientParticulier'];

        $requete = "select id as ID,code_facture as Code from facture 
                where client=:CodeClient 
                and etat_Facture='Finale' 
                and statutFacture<>'Reglee' 
                and (date_facturation between :dateCreationDu AND :dateCreationAu )";

        $statement = $connection->prepare($requete);

        $statement->bindValue('dateCreationDu', $dateCreationDu);
        $statement->bindValue('dateCreationAu', $dateCreationAu);
        if ($CodeClientCompte != -1) {
            $statement->bindValue('CodeClient', $CodeClientCompte);
        } else {
            $statement->bindValue('CodeClient', $CodeClientParticulier);
        }
        $statement->execute();
        $results = $statement->fetchAll();
        if (sizeof($results) >= 1) {
            $response = array();
            foreach ($results as $res) {
                $response[] = array_merge(
                        array(
                            "IDFacture" => $res['ID'],
                            "CodeFacture" => $res['Code'],
                ));
            }

            return new Response(json_encode($response));
        } else {

            $response = array("codeError" => 40,
                "message" => "Aucune facture trouvée",);
            return new Response(json_encode($response));
        }
    }

    public function FindMontantindexAddReglementAction() {
        $em = $this->getDoctrine()->getManager();

        $connection = $em->getConnection();

        $params = $this->getRequest()->request->all();

        $ListIDsFacture = $params['ListIDsFacture'];

        $ids = array();
        foreach ($ListIDsFacture as $value) {
            array_push($ids, $value);
        }

        $inQuery = implode(',', array_fill(0, count($ids), '?'));

        $requete = "select f.id as ID,
                f.code_facture as Code,
                f.montantTTC as AllTTC,
                (f.montantTTC-sum(case  when rf.montantReglement is not null then rf.montantReglement else 0 end)) as Rest
                from facture f 
                left join reglement_facture rf on (rf.facture=f.id)
                where f.id IN(" . $inQuery . ")
                group by f.id";

        $statement = $connection->prepare($requete);

        foreach ($ids as $k => $id) {
            $statement->bindValue(($k + 1), $id);
        }
        $statement->execute();
        $results = $statement->fetchAll();
        if (sizeof($results) >= 1) {
            $response = array();
            foreach ($results as $res) {
                $response[] = array_merge(
                        array(
                            "IDFacture" => $res['ID'],
                            "CodeFacture" => $res['Code'],
                            "TTC" => $res['AllTTC'],
                            "rest" => $res['Rest'],
                ));
            }

            return new Response(json_encode($response));
        } else {

            $response = array("codeError" => 40,
                "message" => "Aucune facture trouvée",);
            return new Response(json_encode($response));
        }
    }

    public function createAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $connection = $em->getConnection();

        $params = $this->getRequest()->request->all();

        $ListIDsFacture = $params['IDFactures'];
        $ListMontantsFacture = $params['montantsFactures'];
        $ModeRegl = $params['ModeRegl'];
        $montantRegl = floatval($params['montantRegl']);
        $refRegl = $params['refRegl'];
        $DateEffet = $params['DateEffet'];
        $Reglement = new Reglement();
        $Reglement->setModeReglement($ModeRegl);
        $Reglement->setRefReglement($refRegl);
        $Reglement->setMontantReglement($montantRegl);
        $Reglement->setDateCreation(new \DateTime());
        $Reglement->setDateEffet(new \DateTime($DateEffet));

        $em->persist($Reglement);
        $em->flush();

        foreach ($ListIDsFacture as $key => $value) {
            $facture = $em->getRepository('ComDaufinBundle:Facture')->find($value);
            if ($ListMontantsFacture[$key] < $facture->getTotalMontantTTC()) {
                $facture->setStatutFacture("Partiel");
            } else if ($ListMontantsFacture[$key] = $facture->getTotalMontantTTC()) {
                $facture->setStatutFacture("Reglee");
            }
            $ReglementFacture = new ReglementFacture();
            $ReglementFacture->setFacture($facture);
            $ReglementFacture->setReglement($Reglement);
            $ReglementFacture->setMontant($ListMontantsFacture[$key]);
            $ReglementFacture->setDateCreation(new \DateTime());
            $em->persist($ReglementFacture);
        }

        $em->flush();

        $response = array(
            "Message" => "Reglement Créé ",
            "statut" => "1",);

        return new Response(json_encode($response));
    }

    /**
     * Finds and displays a ReglementFacture entity.
     *
     * @Route("/{id}", name="com_RegleFacture_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();
        $connection = $em->getConnection();
        $Reglement = $em->getRepository('ComDaufinBundle:Reglement')->find($id);
        $request = "select 

        f.code_facture as CodeFacture,
        f.montantTTC as TTC,
        sum(case  when rf.montantReglement is not null then rf.montantReglement else 0 end) as Paye,
        (f.montantTTC-(select sum(montantReglement) from reglement_facture where facture=f.id)) as Rest

        from facture f 
        left join reglement_facture rf on (rf.facture=f.id)
        join reglement r on (rf.reglement=r.id)
        where r.id=:regl

        group by f.id";

        $statement = $connection->prepare($request);
        $statement->bindValue('regl', $Reglement->getId());
        $statement->execute();
        $results = $statement->fetchAll();

        return $this->render('ComDaufinBundle:ReglementFacture:show.html.twig', array(
                    'entity' => $Reglement,
                    'factures' => $results,
        ));
    }

    public function FindMontantindexEditReglementAction() {
        $em = $this->getDoctrine()->getManager();

        $connection = $em->getConnection();

        $params = $this->getRequest()->request->all();

        $idRegl = $params['idRegl'];

        $requete = "select f.id as ID,
        f.code_facture as CodeFacture,
        f.montantTTC as TTC,
        sum(case  when rf.montantReglement is not null then rf.montantReglement else 0 end) as Paye,
        (f.montantTTC-(select sum(montantReglement) from reglement_facture where facture=f.id)) as Rest

        from facture f 
        left join reglement_facture rf on (rf.facture=f.id)
        join reglement r on (rf.reglement=r.id)
        where r.id=:regl

        group by f.id";

        $statement = $connection->prepare($requete);
        $statement->bindValue('regl', intval($idRegl));

        $statement->execute();
        $results = $statement->fetchAll();
        if (sizeof($results) >= 1) {
            $response = array();
            foreach ($results as $res) {
                $response[] = array_merge(
                        array(
                            "IDFacture" => $res['ID'],
                            "CodeFacture" => $res['CodeFacture'],
                            "TTC" => $res['TTC'],
                            "paye" => $res['Paye'],
                            "rest" => $res['Rest'],
                            "max" => ($res['Rest'] + $res['Paye']),
                ));
            }

            return new Response(json_encode($response));
        } else {

            $response = array("codeError" => 40,
                "message" => "Aucune facture trouvée",);
            return new Response(json_encode($response));
        }
    }

    /**
     * Displays a form to edit an existing ReglementFacture entity.
     *
     * @Route("/{id}/edit", name="com_RegleFacture_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();
        $connection = $em->getConnection();
        $Reglement = $em->getRepository('ComDaufinBundle:Reglement')->find($id);
        $request = "select f.id as ID,f.code_facture as Code
                from facture f 
                left join reglement_facture rf on (rf.facture=f.id)
                left join reglement r on (rf.reglement=r.id)
                where r.id=:id";

        $statement = $connection->prepare($request);
        $statement->bindValue('id', $id);
        $statement->execute();
        $AllFactures = $statement->fetchAll();
        return $this->render('ComDaufinBundle:ReglementFacture:edit.html.twig', array(
                    'Reglement' => $Reglement,
                    'AllFactures' => $AllFactures,
        ));
    }

    public function updateAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $connection = $em->getConnection();

        $params = $this->getRequest()->request->all();

        $id = intval($params['idRegl']);
        $ListIDsFacture = $params['IDFactures'];
        $ListMontantsFacture = $params['montantsFactures'];
        $ModeRegl = $params['ModeRegl'];
        $montantRegl = floatval($params['montantRegl']);
        $refRegl = $params['refRegl'];
        $DateEffet = $params['DateEffet'];
        $Reglement = $em->getRepository('ComDaufinBundle:Reglement')->find($id);
        $Reglement->setModeReglement($ModeRegl);
        $Reglement->setRefReglement($refRegl);
        $Reglement->setMontantReglement($montantRegl);
        $Reglement->setDateEffet(new \DateTime($DateEffet));

        $em->flush();

        foreach ($ListIDsFacture as $key => $value) {
            $facture = $em->getRepository('ComDaufinBundle:Facture')->find($value);
            if ($ListMontantsFacture[$key] < $facture->getTotalMontantTTC()) {
                $facture->setStatutFacture("Partiel");
            } else if ($ListMontantsFacture[$key] = $facture->getTotalMontantTTC()) {
                $facture->setStatutFacture("Reglee");
            }
            $ReglementFacture = $em->getRepository('ComDaufinBundle:ReglementFacture')->findOneBy(
                    array(
                        'facture' => $facture->getId(),
                        'reglement' => $Reglement->getId())
            );
            $ReglementFacture->setMontant($ListMontantsFacture[$key]);
            $em->persist($ReglementFacture);
        }

        $em->flush();
        $response = array(
            "Message" => "Reglement modifié ",
            "statut" => "1",);

        return new Response(json_encode($response));
    }

    public function showDetailsFactureAction($idfacture, $idReglement) {
        $em = $this->getDoctrine()->getManager();
        $connection = $em->getConnection();
        $Facture = $em->getRepository('ComDaufinBundle:Facture')->find($idfacture);
        $request = "select  r.date_creation as DateCreation,
        r.mode_reglement as mode,
        r.ref_reglement as ref,
        r.montantreglement as MTRegl,
        rf.montantreglement as MTFacture
        from reglement_facture rf 
        join reglement r on (rf.reglement=r.id)
        where rf.facture=:idFacture";

        $statement = $connection->prepare($request);
        $statement->bindValue('idFacture', $idfacture);
        $statement->execute();
        $results = $statement->fetchAll();

        return $this->render('ComDaufinBundle:ReglementFacture:showFacture.html.twig', array(
                    'Facture' => $Facture,
                    'idReglement' => $idReglement,
                    'reglements' => $results,
        ));
    }

    /**
     * Deletes a ReglementFacture entity.
     *
     * @Route("/{id}", name="com_RegleFacture_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ComDaufinBundle:ReglementFacture')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find ReglementFacture entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('com_RegleFacture'));
    }

    /**
     * Creates a form to delete a ReglementFacture entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('com_RegleFacture_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Delete'))
                        ->getForm()
        ;
    }

}
