<?php

namespace Com\DaufinBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Com\DaufinBundle\Entity\ExptranspVoyage;
use Com\DaufinBundle\Entity\ExpTransp;
use Com\DaufinBundle\Form\ExptranspVoyageType;
use Com\DaufinBundle\Entity\Trajet;
use Com\DaufinBundle\Entity\Vehicule;
use Com\DaufinBundle\Entity\OpererVoyage;

/**
 * ExptranspVoyage controller.
 *
 */
class ExptranspVoyageController extends Controller
{

    /**
     * Lists all ExptranspVoyage entities.
     *
     */
	public function validChargementAction()
	{
		$em = $this->getDoctrine()->getManager();
	
		$voyages = $em->getRepository('ComDaufinBundle:Voyage')->findAll();
		$trajets= $em->getRepository('ComDaufinBundle:Trajet')->findAll();
		$vehicules=$em->getRepository('ComDaufinBundle:Vehicule')->findAll();
	
	
		return $this->render('ComDaufinBundle:ExptranspVoyage:validChargement.html.twig', array(
				'voyages' => $voyages,
				'trajets' => $trajets,
			    'vehicules' => $vehicules,
		));
	}
	public function feuilleChargementAction()
	{
		$em = $this->getDoctrine()->getManager();
	
	
		$connection = $em->getConnection();
		
		$statement = $connection->prepare("select v.id as idVoyage, v.etat_voyage as EtatVoyage,v.Date_Planif as DatePlanif, v.date_valid as DateValidate,
				                                  t.Libelle_trajet as libelleTrajet
				                          from 
				                              voyage v,vehi_traj_voyg vtv,trajet t 
				                          where 
				                                  v.etat_voyage='Validation'
				                              AND vtv.voyage=v.id
				                              AND vtv.trajet=t.id   ");
		$statement->execute();
		$results = $statement->fetchAll();
		
	    return $this->render('ComDaufinBundle:ExptranspVoyage:feuilleChargement.html.twig', array(
				'voyages' => $results,		 
		));
	}
	
	public function propChargementAction()
	{
		$em = $this->getDoctrine()->getManager();
	
	//	$voyages = $em->getRepository('ComDaufinBundle:Voyage')->findAll();
		$trajets= $em->getRepository('ComDaufinBundle:Trajet')->findAll();
	//	$vehicules=$em->getRepository('ComDaufinBundle:Vehicule')->findAll();
		
	   
		return $this->render('ComDaufinBundle:ExptranspVoyage:propChargement.html.twig', array(
		//		'voyages' => $voyages,
				'trajets' => $trajets,
		//		'vehicules' => $vehicules,
		));
	}
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ComDaufinBundle:ExptranspVoyage')->findAll();

        return $this->render('ComDaufinBundle:ExptranspVoyage:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new ExptranspVoyage entity.
     *
     */
 public function createAction(Request $request)
    {
        $ids=$request->get('ExpTrsp');
        $dateAff=$request->get('dateAffect');
        $idvoyage=$request->get('voyage');
        $voyage=$this->getDoctrine()->getManager()->getRepository('ComDaufinBundle:Voyage')->find($idvoyage);
        if ($ids!=NULL)
        {
        foreach($ids as $id)
        {
            $idExTr=$this->getDoctrine()->getManager()->getRepository('ComDaufinBundle:ExpTransp')->find($id);
            $ExptranspVoyage = new ExptranspVoyage();
            $ExptranspVoyage->setdateAff(new \DateTime($dateAff));
            $ExptranspVoyage->setvoyage($voyage);
            $ExptranspVoyage->setexpTransp($idExTr);   
            $this->getDoctrine()->getManager()->persist($ExptranspVoyage);
            $this->getDoctrine()->getManager()->flush();
        }
        $voyage->setEtatVoyage('Validation');
        $perso = $this->getUser()->getPersonnel();
        $operVoyage=new OpererVoyage();
        $operVoyage->setDateOperation(new \DateTime());
        $operVoyage->setTypeOperation("Validation");
        $operVoyage->setPersonnel($perso);
        $operVoyage->setVoyage($voyage);
        $this->getDoctrine()->getManager()->persist($operVoyage);
        $this->getDoctrine()->getManager()->flush();
        }
        
        return $this->newAction();

    }

    /**
     * Creates a form to create a ExptranspVoyage entity.
     *
     * @param ExptranspVoyage $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(ExptranspVoyage $entity)
    {
        $form = $this->createForm(new ExptranspVoyageType(), $entity, array(
            'action' => $this->generateUrl('com_Exptransp_Voyage_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Créer','attr'=>array('class'=>'btn btn-success','style'=>'width:100px;')));

        return $form;
    }

    /**
     * Displays a form to create a new ExptranspVoyage entity.
     *
     */
    public function newAction()
    {
        $entity = new ExptranspVoyage();
        $form   = $this->createCreateForm($entity);
        $trajets = $this->getDoctrine()->getRepository('ComDaufinBundle:Trajet')->findAll();


        return $this->render('ComDaufinBundle:ExptranspVoyage:new.html.twig', array(
            'entity' => $entity,
            'trajets' => $trajets,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a ExptranspVoyage entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:ExptranspVoyage')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ExptranspVoyage entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ComDaufinBundle:ExptranspVoyage:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing ExptranspVoyage entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:ExptranspVoyage')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ExptranspVoyage entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ComDaufinBundle:ExptranspVoyage:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a ExptranspVoyage entity.
    *
    * @param ExptranspVoyage $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(ExptranspVoyage $entity)
    {
        $form = $this->createForm(new ExptranspVoyageType(), $entity, array(
            'action' => $this->generateUrl('com_Exptransp_Voyage_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Modifier','attr'=>array('class'=>'btn btn-warning','style'=>'width:100px;')));

        return $form;
    }
    /**
     * Edits an existing ExptranspVoyage entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:ExptranspVoyage')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ExptranspVoyage entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('com_Exptransp_Voyage_edit', array('id' => $id)));
        }

        return $this->render('ComDaufinBundle:ExptranspVoyage:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a ExptranspVoyage entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ComDaufinBundle:ExptranspVoyage')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find ExptranspVoyage entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('com_Exptransp_Voyage'));
    }

    /**
     * Creates a form to delete a ExptranspVoyage entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('com_Exptransp_Voyage_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Supprimer','attr'=>array('class'=>'btn btn-danger','style'=>'width:100px;')))
            ->getForm()
        ;
    }
}
