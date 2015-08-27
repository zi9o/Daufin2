<?php

namespace Com\DaufinBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use Com\DaufinBundle\Entity\Agence;
use Com\DaufinBundle\Form\AgenceType;
use Com\DaufinBundle\Entity\Caisse;
use Com\DaufinBundle\Entity\MouvementCaisse;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * Agence controller.
 *
 */
class AgenceController extends Controller
{

    /**
     * Lists all Agence entities.
     * @Secure(roles="ROLE_SHOW_ALL_AGENCE")
     */
     
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ComDaufinBundle:Agence')->findAll();

        return $this->render('ComDaufinBundle:Agence:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Agence entity.
     * @Secure(roles="ROLE_ADD_AGENCE")
     */
    public function createAction(Request $request)
    {
    	$params = $this->getRequest()->request->all();
    	 
    	
    	$libelleCaisse=$params['libelleCaisse'];
    	$typeCaisse=$params['typeCaisse'];
    	$soldeCaisse=$params['soldeCaisse'];
    	
    	$caisse=new Caisse();
    	$caisse->setTypeCaisse($typeCaisse);
    	$caisse->setDateDebut(new \DateTime());
    	$caisse->setLibelleCaisse($libelleCaisse);
    	$caisse->setSoldeCaisse($soldeCaisse);
    	
    	$mouvementCaisse=new MouvementCaisse();
    	$mouvementCaisse->setDateMouvement(new \DateTime());
    	$mouvementCaisse->setPersonnel($this->getUser()->getPersonnel());
    	$mouvementCaisse->setValeur($soldeCaisse);
    	$mouvementCaisse->setTypeMouvement("Virsement");
    	$mouvementCaisse->setLibelleMouvement("Virsement Solde Initial ");
    	
    	
        $entity = new Agence();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $caisse->setAgence($entity);
            $em->persist($caisse);
            $em->flush();
            $mouvementCaisse->setAgence($entity);
            $mouvementCaisse->setCaisse($caisse);
            $em->persist($mouvementCaisse);
            $em->flush();
            return $this->redirect($this->generateUrl('com_agence_show', array('id' => $entity->getId())));
        }

        return $this->render('ComDaufinBundle:Agence:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Agence entity.
     *
     * @param Agence $entity The entity
     * @Secure(roles="ROLE_ADD_AGENCE")
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Agence $entity)
    {
        $form = $this->createForm(new AgenceType(), $entity, array(
            'action' => $this->generateUrl('com_agence_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Créer','attr'=>array('class'=>'btn btn-success','style'=>'width:100px;')));

        return $form;
    }

    /**
     * Displays a form to create a new Agence entity.
     * @Secure(roles="ROLE_ADD_AGENCE")
     */
    public function newAction()
    {
        $entity = new Agence();
        $form   = $this->createCreateForm($entity);

        return $this->render('ComDaufinBundle:Agence:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Agence entity.
     * @Secure(roles="ROLE_SHOW_AGENCE")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:Agence')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Agence entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ComDaufinBundle:Agence:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Agence entity.
     * @Secure(roles="ROLE_EDIT_AGENCE")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:Agence')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Agence entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ComDaufinBundle:Agence:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Agence entity.
    *
    * @param Agence $entity The entity
    * @Secure(roles="ROLE_EDIT_AGENCE")
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Agence $entity)
    {
        $form = $this->createForm(new AgenceType(), $entity, array(
            'action' => $this->generateUrl('com_agence_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Modifier','attr'=>array('class'=>'btn btn-warning','style'=>'width:100px;')));

        return $form;
    }
    /**
     * Edits an existing Agence entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ComDaufinBundle:Agence')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Agence entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('com_agence_edit', array('id' => $id)));
        }

        return $this->render('ComDaufinBundle:Agence:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Agence entity.
     * @Secure(roles="ROLE_DELETE_AGENCE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ComDaufinBundle:Agence')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Agence entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('com_agence'));
    }

    /**
     * Creates a form to delete a Agence entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('com_agence_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Supprimer','attr'=>array('class'=>'btn btn-danger','style'=>'width:100px;')))
            ->getForm()
        ;
    }
}
