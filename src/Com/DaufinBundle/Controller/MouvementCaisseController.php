<?php

namespace Com\DaufinBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Com\DaufinBundle\Entity\MouvementCaisse;
use Com\DaufinBundle\Form\MouvementCaisseType;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * MouvementCaisse controller.
 *
 * @Route("/com_mouvnt_caisse")
 */
class MouvementCaisseController extends Controller
{

    /**
     * Lists all MouvementCaisse entities.
     *
     * @Route("/", name="com_mouvnt_caisse")
     * @Method("GET")
     * @Template()
     * @Secure(roles="ROLE_SHOW_ALL_MOUVEMENT_CAISSE")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ComDaufinBundle:MouvementCaisse')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new MouvementCaisse entity.
     *
     * @Route("/", name="com_mouvnt_caisse_create")
     * @Method("POST")
     * @Template("ComDaufinBundle:MouvementCaisse:new.html.twig")
     * @Secure(roles="ROLE_ADD_MOUVEMENT_CAISSE")
     */
    public function createAction(Request $request)
    {
    	$em = $this->getDoctrine()->getManager();  	 
    	$connection = $em->getConnection();
    	 
    	$idAgence;
    	$statement = $connection->prepare("SELECT ag.id as id FROM agence ag,affecter af
        		                           where af.personnel=:personnel AND
        		                                 af.agence=ag.id");
    	$statement->bindValue('personnel', $this->getUser()->getPersonnel()->getId());
    	$statement->execute();
    	$args=$statement->fetchAll();
    	if(sizeof($args)>=1){
    		$idAgence=$args[0]['id'];
    	}
    	$caisse=$em->getRepository("ComDaufinBundle:Caisse")->findOneByAgence($idAgence);
    	 
    	///$caisse=new Caisse();
    	// Virement vers la caisse
    	//Creer Mouvement
    	 
        $entity = new MouvementCaisse();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            
        $entity->setDateMouvement(new \DateTime());
        $entity->setAgence($caisse->getAgence());
       // $entity->setCaisse($caisse);
        $entity->setPersonnel($this->getUser()->getPersonnel());
        if($entity->getTypeMouvement()=='Retrait')
            $entity->getCaisse()->setSoldeCaisse($entity->getCaisse()->getSoldeCaisse()-$entity->getValeur());
        else  
        	$entity->getCaisse()->setSoldeCaisse($entity->getCaisse()->getSoldeCaisse()+$entity->getValeur());
    	
          $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('com_mouvnt_caisse_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a MouvementCaisse entity.
     *
     * @param MouvementCaisse $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(MouvementCaisse $entity)
    {
        $form = $this->createForm(new MouvementCaisseType(), $entity, array(
            'action' => $this->generateUrl('com_mouvnt_caisse_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new MouvementCaisse entity.
     *
     * @Route("/new", name="com_mouvnt_caisse_new")
     * @Method("GET")
     * @Template()
     * @Secure(roles="ROLE_ADD_MOUVEMENT_CAISSE")
     */
    public function newAction()
    {
        $entity = new MouvementCaisse();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a MouvementCaisse entity.
     *
     * @Route("/{id}", name="com_mouvnt_caisse_show")
     * @Method("GET")
     * @Template()
     * @Secure(roles="ROLE_SHOW_MOUVEMENT_CAISSE")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:MouvementCaisse')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MouvementCaisse entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing MouvementCaisse entity.
     *
     * @Route("/{id}/edit", name="com_mouvnt_caisse_edit")
     * @Method("GET")
     * @Template()
     * @Secure(roles="ROLE_EDIT_MOUVEMENT_CAISSE")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:MouvementCaisse')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MouvementCaisse entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a MouvementCaisse entity.
    *
    * @param MouvementCaisse $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(MouvementCaisse $entity)
    {
        $form = $this->createForm(new MouvementCaisseType(), $entity, array(
            'action' => $this->generateUrl('com_mouvnt_caisse_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing MouvementCaisse entity.
     *
     * @Route("/{id}", name="com_mouvnt_caisse_update")
     * @Method("PUT")
     * @Template("ComDaufinBundle:MouvementCaisse:edit.html.twig")
     * @Secure(roles="ROLE_EDIT_MOUVEMENT_CAISSE")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:MouvementCaisse')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MouvementCaisse entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('com_mouvnt_caisse_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a MouvementCaisse entity.
     *
     * @Route("/{id}", name="com_mouvnt_caisse_delete")
     * @Method("DELETE")
     * @Secure(roles="ROLE_DELETE_MOUVEMENT_CAISSE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ComDaufinBundle:MouvementCaisse')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find MouvementCaisse entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('com_mouvnt_caisse'));
    }

    /**
     * Creates a form to delete a MouvementCaisse entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('com_mouvnt_caisse_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
