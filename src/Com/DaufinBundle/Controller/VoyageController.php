<?php

namespace Com\DaufinBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Com\DaufinBundle\Entity\Voyage;
use Com\DaufinBundle\Entity\VehiTrajVoyg;
use Com\DaufinBundle\Form\VoyageType;
use Com\DaufinBundle\Entity\OpererVoyage;

/**
 * Voyage controller.
 *
 */
class VoyageController extends Controller
{

    /**
     * Lists all Voyage entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        //$entities = $em->getRepository('ComDaufinBundle:Voyage')->findAll();
        
        $connection = $em->getConnection();
        
        $statement = $connection->prepare("SELECT v.id as idVoyage,v.Etat_Voyage as etatVoyage,v.Date_planif as datePlanification,
        		                                  vtv.Date_Passer as datePasse,vh.matricule_veh as matriculeVehicule,
        		                                  t.Libelle_Trajet as libelleTrajet,
        		                                  p.nom_Pers as nomPersonnel,p.prenom_pers as prenomPersonnel,p.matricule_pers as matriculePersonnel,
        		                                  p.id as idPersonnel,t.id as idTrajet,vh.id as idVehicule 
        		                                  FROM voyage v,vehi_traj_voyg vtv,vehicule vh,trajet t,personnel p
        		                                   
        		                                   where vtv.voyage=v.id AND vtv.trajet=t.id AND
        		                                         vtv.vehicule=vh.id AND vtv.chauffeur=p.id ");
        
       // $statement->bindValue('vehicule',$idVehicule);
        $statement->execute();
        $entities = $statement->fetchAll();

        return $this->render('ComDaufinBundle:Voyage:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Voyage entity.
     *
     */
    public function createAction(Request $request)
    {    
    	$params = $this->getRequest()->request->all();   
    	
        $trjt=$params['idTrajet'];
        $veh=$params['idVehicule'];
     //   $date=['date'];
        
        $user=$this->getUser();
        $personnel=$user->getPersonnel();
       
        
        echo 'veh='.$veh.'Traj='.$trjt;
        $em = $this->getDoctrine()->getManager();
        
        $voyage = new Voyage();

        //echo $date;
            $voyage->setEtatVoyage('Planification');
         //   $voyage->setDatePlanif(new \DateTime($date));
            $em->persist($voyage);
            $em->flush();
            
            $trajet=$em->getRepository('ComDaufinBundle:Trajet')->find($trjt);
            $vehicule=$em->getRepository('ComDaufinBundle:Vehicule')->find($veh);
            
            $vehiTrajVoyg = new VehiTrajVoyg();
            $vehiTrajVoyg->setvoyage($voyage);
            $vehiTrajVoyg->settrajet($trajet);
            $vehiTrajVoyg->setvehicule($vehicule);
            $vehiTrajVoyg->setdatePasser(new \DateTime());
            
            $operVoyage=new OpererVoyage();
            $operVoyage->setVoyage($voyage);
            $operVoyage->setPersonnel($personnel);
            $operVoyage->setTypeOperation("Planification");
            $operVoyage->setDateOperation(new \DateTime());
            $em->persist($operVoyage);
            
            $em->persist($vehiTrajVoyg);
            $em->flush();
            
            return $this->redirect($this->generateUrl('com_voyage_show', array('id' => $voyage->getId())));
    }

    /**
     * Creates a form to create a Voyage entity.
     *
     * @param Voyage $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Voyage $entity)
    {
        $form = $this->createForm(new VoyageType(), $entity, array(
            'action' => $this->generateUrl('com_voyage_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Créer','attr'=>array('class'=>'btn btn-success','style'=>'width:100px;')));

        return $form;
    }

    /**
     * Displays a form to create a new Voyage entity.
     *
     */
    public function newAction()
    {
        $em = $this->getDoctrine()->getManager();
        $trajets = $em->getRepository('ComDaufinBundle:Trajet')->findAll();
        $vehicules = $em->getRepository('ComDaufinBundle:Vehicule')->findAll();
        
        $connection = $em->getConnection();
        $statement = $connection->prepare("SELECT p.id as idChauffeur,p.Nom_PERS as nom,p.prenom_pers as prenom,p.matricule_pers as matricule
          		                             FROM  personnel p  WHERE p.fonction like '%convoyeur%'
                                              " );
      //  WHERE p.fonction like '%convoyeur%'
         $statement->execute();
        $results = $statement->fetchAll();
        
        
        return $this->render('ComDaufinBundle:Voyage:new.html.twig', array(          
            'trajets'=>$trajets,
            'vehicules'=>$vehicules,
        	'chauffeurs'=>$results,	
           
        ));
    }

    /**
     * Finds and displays a Voyage entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:Voyage')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Voyage entity.');
        }
        $deleteForm = $this->createDeleteForm($id);


        return $this->render('ComDaufinBundle:Voyage:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Voyage entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:Voyage')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Voyage entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ComDaufinBundle:Voyage:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Voyage entity.
    *
    * @param Voyage $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Voyage $entity)
    {
        $form = $this->createForm(new VoyageType(), $entity, array(
            'action' => $this->generateUrl('com_voyage_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Modifier','attr'=>array('class'=>'btn btn-warning','style'=>'width:100px;')));

        return $form;
    }
    /**
     * Edits an existing Voyage entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:Voyage')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Voyage entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('com_voyage_edit', array('id' => $id)));
        }

        return $this->render('ComDaufinBundle:Voyage:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Voyage entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ComDaufinBundle:Voyage')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Voyage entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('com_voyage'));
    }

    /**
     * Creates a form to delete a Voyage entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('com_voyage_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Supprimer','attr'=>array('class'=>'btn btn-danger','style'=>'width:100px;')))
            ->getForm()
        ;
    }
}
